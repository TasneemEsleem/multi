<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Database\QueryException;
use App\Exceptions\ExceptionHandlerTrait;
use App\Exceptions\CustomException1;
use App\Exceptions\CustomException2;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Response;

class PaymentsController extends Controller
{
    use ExceptionHandlerTrait;

    public function create(Order $order)
    {
        return response()->view('landingPage.payments', ['order' => $order]);
    }
    // Create Payment In the Web
    public function createStripePaymentIntent(Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $amount = $order->total_amount * 100;

        $intent = $stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'ILS',
            'payment_method_types' => ['card'],
        ]);
        try {
            $payment = new Payment();
            $payment->forceFill([
                'order_id' => $order->id,
                'amount' => $intent->amount,
                'currency' => $intent->currency,
                'status' => 'pending',
                'method' => 'stripe',
                'transaction_id' => $intent->id,
                'transaction_data' => json_encode($intent),
            ])->save();
        } catch (QueryException $e) {
            $e->getMessage();
            return;
        }
        return CustomException::validMessage(
            [
                'clientSecret' => $intent->client_secret,
                'payment_intent' => $intent->id,
            ],
            'Payment intent created successfully',
            200
        );
    }
    // Confirm Payment In The Web
    public function confirm(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );
        if ($paymentIntent->status == 'succeeded') {
            try {
                $payment = Payment::where('order_id', $order->id)->first();
                $payment->forceFill([
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();
            } catch (QueryException $e) {
                $e->getMessage();
                return;
            }
            // event('Payment.create', $payment->id);
            return redirect()->route('dashboard-customer', ['status' => 'payement-succeed']);
        }
        return redirect()->route('stripe.paymentIntel.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status
        ]);
    }

    //  Payment Method Use In Api .....
    public function createAndConfirmStripePaymentIntent(Request $request, Order $order)
    {
        try {
            $stripe = new StripeClient(config('services.stripe.secret_key'));
            $amount = $order->total_amount * 100;
            // Create the payment intent
            $intent = $stripe->paymentIntents->create([
                'amount' => $amount,
                'currency' => 'ILS',
                'payment_method' => $request->input('payment_method'),
                'confirm' => true,
            ]);
            if ($intent->status === 'succeeded') {
                $payment = new Payment();
                $payment->forceFill([
                    'order_id' => $order->id,
                    'amount' => $intent->amount,
                    'currency' => $intent->currency,
                    'status' => 'completed',
                    'method' => 'stripe',
                    'transaction_id' => $intent->id,
                    'transaction_data' => json_encode($intent),
                ])->save();
                return CustomException::validMessage(
                    [
                       'message' => 'Payment confirmed and saved successfully',
                    ],
                    Response::HTTP_OK
                );
            } else {
                return CustomException::errorMessage([
                    'message' => 'Payment confirmation failed. Please try again.',
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (CustomException1 $e) {
            return $this->handleException($e);
        } catch (CustomException2 $e) {
            return $this->handleException($e);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
