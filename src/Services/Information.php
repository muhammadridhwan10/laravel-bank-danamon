<?php

namespace Ridhwan\LaravelBankDanamon\Services;

use Ridhwan\LaravelBankDanamon\Danamon;

class Information extends Danamon
{
    /**
     * __construct
     *
     * @param  string $token
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * BalanceInformation
     * @param  array $fields
     * @return \Ridhwan\Response\Response
     */
    public function AccountInquiryBalance(array $fields)
    {
        $requestUrl = "/v1/api/financialinfo/casa/accountinquirybalance";
        return $this->sendRequest('POST', $requestUrl, $fields);
    }

    /**
     * AccountStatement
     * @param  array $fields
     * @return \Ridhwan\Response\Response
     */
    public function AccountStatement(array $fields)
    {
        $requestUrl = "/v1/api/financialinfo/casa/accountstatement";
        return $this->sendRequest('POST', $requestUrl, $fields);
    }

    /**
     * FundTransfer
     *
     * @param  array $fields
     * @return \Ridhwan\Response\Response
     */
    public function Transfer(array $fields)
    {
        $requestUrl = '/v1/api/financialtransaction/transfer/cashoutonline';
        return $this->sendRequest('POST', $requestUrl, $fields);
    }

}
