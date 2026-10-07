<?php

namespace App\Services\Gateway;

class YourGateway
{
   
    // Bkash Configs
    public function getConfig(): array
    {
        return [
            'name'     => 'Your Gateway', // replace with your Gateway name
            'currency' => 'USD', // replace with your Gateway currency
            'charge' => 2, // replace with your Gateway charge
            'logo' => '/resource/bkash_logo.png', // upload your Gateway logo to public/resource folder
            'min_limit' => 1, // replace with your Gateway minimum limit
            'max_limit' => 30000, // replace with your Gateway maximum limit
            'callback_methode' => ['browser'], // payment verification will by browser callback
            'fields'   => [
                [
                    'key'         => 'your_payment_gateway_app_key',
                    'label'       => 'Your Gateway APP Key',
                    'type'        => 'text',
                ],
                [
                    'key'         => 'your_payment_gateway_sandbox',
                    'label'       => 'Your Gateway Sandbox',
                    'type'        => 'checkbox',
                ],
                // [
                //     'key'         => 'more_field',
                //     'label'       => 'More fields if need',
                //     'type'        => 'text',
                // ],
                // [
                //     'key'         => 'more_field',
                //     'label'       => 'More fields if need',
                //     'type'        => 'text',
                // ],
                
            ],
        ];
    }

    // CREATE PAYMENT
    public function createPayment($data)
    {
        // $data output
        // \Log::info($data);

        // [2026-10-07 06:48:02] local.INFO: array (
        //     'invoice' => 
        //     array (
        //         'id' => 37,
        //         'invoice_due_amount' => '100',
        //         'invoice_currency' => 'USD',
        //         'invoice_title' => 'Deposit in GSM Theme',
        //         'invoice_reference' => '',
        //         'invoice_status' => 'Unpaid',
        //     ),
        //     'gateway' => 
        //     array (
        //         'id' => 39,
        //         'gateway_class' => 'YourGateway',
        //         'gateway_name' => 'Your Gateway',
        //         'gateway_currency' => 'USD',
        //         'gateway_charge' => '2',
        //         'gateway_min_limit' => '1',
        //         'gateway_max_limit' => '30000',
        //         'field' => 
        //         array (
        //         'your_payment_gateway_app_key' => 'Xlb9BW48NBNMG54UJuH4AE7lo3tc',
        //         'your_payment_gateway_sandbox' => 'false',
        //         ),
        //     ),
        //     'customer' => 
        //     array (
        //         'id' => 5,
        //         'name' => 'tuhin',
        //         'email' => 'gfdgfvd@gmail.com',
        //         'mobile' => '544454545555',
        //     ),
        //     'callback' => 
        //     array (
        //         'success_url' => 'http://127.0.0.1:8000/gateway-callback/Mzc=/Qmthc2g=/success',
        //         'cancel_url' => 'http://127.0.0.1:8000/gateway-callback/Mzc=/Qmthc2g=/cancel',
        //         'webhook_url' => 'http://127.0.0.1:8000/public/api/gateway-webhook/Qmthc2g=',
        //     ),
        // )  


        // Write payment create response for your payment gateway 


        $response = 'your payment gateway response';

        if (isset($response['checkout_url']) && $response['checkout_url']) {
            return [
                'url' => $response['checkout_url'], // checkout url
                'response' => $response // payment create  response
            ];
        }

        return [
            'message' => $response['message'], // payment create error message
            'response' => $response, // payment create error response
        ];

    }

    // BROWSER CALLBACK
    public function browserCallback($data, $request = null)
    {

        // \Log::info($data);

        // \Log::info($request);

        // [2026-10-07 06:55:54] local.INFO: array (
        //     'invoice' => 
        //     array (
        //         'id' => 38,
        //         'invoice_due_amount' => '100',
        //         'invoice_currency' => 'USD',
        //         'invoice_title' => 'Deposit in GSM Theme',
        //         'invoice_reference' => '',
        //         'invoice_status' => 'Unpaid',
        //     ),
        //     'gateway' => 
        //     array (
        //         'id' => 39,
        //         'gateway_class' => 'YourGateway',
        //         'gateway_name' => 'Your Gateway',
        //         'gateway_currency' => 'USD',
        //         'gateway_charge' => '2',
        //         'gateway_min_limit' => '1',
        //         'gateway_max_limit' => '30000',
        //         'field' => 
        //         array (
        //         'your_payment_gateway_app_key' => 'Xlb9BW48NBNMG54UJuH4AE7lo3tc',
        //         'your_payment_gateway_sandbox' => 'false',
        //         ),
        //     ),
        //     'customer' => 
        //     array (
        //         'id' => 5,
        //         'name' => 'tuhin',
        //         'email' => 'gfdgfvd@gmail.com',
        //         'mobile' => '544454545555',
        //     ),
        //     'callback' => 
        //     array (
        //         'success_url' => 'http://127.0.0.1:8000/gateway-callback/Mzg=/Qmthc2g=/success',
        //         'cancel_url' => 'http://127.0.0.1:8000/gateway-callback/Mzg=/Qmthc2g=/cancel',
        //         'webhook_url' => 'http://127.0.0.1:8000/public/api/gateway-webhook/Qmthc2g=',
        //     ),
        // )  


        // [2026-10-07 06:55:54] local.INFO: array (
        //     'paymentID' => 'TR0011bAK1fDp1791356086084',
        //     'status' => 'success',
        //     'signature' => 'ke0ZfsZnh9',
        //     'apiVersion' => '1.2.0-beta/',
        // )  



        if ($request->status == 'success'){

            $response = CheckYourPayment::CheckYourPayment($request->paymentID); // write your payment verification login here

            if ($response['statusCode'] == "0000" && $response['transactionStatus'] == "Completed" ) {
                return [
                    'verified' => true,
                    'message' => 'Transaction Successfull',
                    'invoice_id' => $response['invoice_id'] ?? $data['invoice']['id'],
                    'amount' => $response['amount'],
                    'currency' => 'UDT',
                    'trx_id' => $response['trxID'],
                    'response' => $response ?? '',
                ];
            }

            return [
                'verified' => false, 
                'message' => $response['statusMessage'] ?? 'Your transaction is failed.',
                'response' => $response ?? '',
            ];

        }else if ($request->status == 'cancel'){
            return [
                'verified' => false, 
                'message' => 'Your payment is canceled.',
                'response' => $response ?? '',
            ];

        }else{

            return [
                'verified' => false, 
                'message' => 'Your transaction is failed.',
                'response' => $response ?? '',
            ];

        }

    }
}