<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\Requests\UploadInvoiceRequest;

it('builds upload invoice request', function () {
    $request = new UploadInvoiceRequest(24, Carbon::parse('2023-10-09 10:58:18'), Carbon::parse('2023-10-19 00:00:00'), 202310045, 'base64data');

    expect($request->toArray())->toBe([
        'invoiceId' => 24,
        'issuedOn' => '2023-10-09 10:58:18',
        'due' => '2023-10-19 00:00:00',
        'vs' => 202310045,
        'file' => 'base64data',
    ]);
});
