<?php

namespace JakubOrava\AffilboxClient;

use JakubOrava\AffilboxClient\Endpoints\Campaigns;
use JakubOrava\AffilboxClient\Endpoints\Conversions;
use JakubOrava\AffilboxClient\Endpoints\Dashboard;
use JakubOrava\AffilboxClient\Endpoints\Instance;
use JakubOrava\AffilboxClient\Endpoints\Invoices;
use JakubOrava\AffilboxClient\Endpoints\Partners;
use JakubOrava\AffilboxClient\Endpoints\Test;

class AffilboxClient extends BaseAffilboxClient
{
    public function test(): Test
    {
        return new Test($this);
    }

    public function dashboard(): Dashboard
    {
        return new Dashboard($this);
    }

    public function instance(): Instance
    {
        return new Instance($this);
    }

    public function invoices(): Invoices
    {
        return new Invoices($this);
    }

    public function partners(): Partners
    {
        return new Partners($this);
    }

    public function conversions(): Conversions
    {
        return new Conversions($this);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this);
    }
}
