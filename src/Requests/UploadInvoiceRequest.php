<?php

namespace JakubOrava\AffilboxClient\Requests;

use Carbon\CarbonInterface;

class UploadInvoiceRequest extends BaseRequest
{
    public function __construct(int $invoiceId, CarbonInterface $issuedOn, CarbonInterface $due, int $vs, string $file)
    {
        $this->addParam('invoiceId', $invoiceId);
        $this->addParam('issuedOn', $issuedOn->format('Y-m-d H:i:s'));
        $this->addParam('due', $due->format('Y-m-d H:i:s'));
        $this->addParam('vs', $vs);
        $this->addParam('file', $file);
    }
}
