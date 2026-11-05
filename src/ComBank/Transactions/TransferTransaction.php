<?php namespace ComBank\Transactions;


use ComBank\Bank\Contracts\BankAccountInterface;
use Combank\Transactions\Contracts\BankTransactionInterface;

class TransferTransaction extends BaseTransaction implements BankTransactionInterface {
    private BankAccountInterface $destinationAccount;

    public function __construct(float $amount, BankAccountInterface $destinationAccount) {
        parent::__construct($amount);
        $this->destinationAccount = $destinationAccount;
    }

    public function applyTransaction(BankAccountInterface $bankAccount): float {
        $transferBalance = $bankAccount->getBalance() - $this->amount;

        $newBalance = $this->destinationAccount->getBalance() + $this->amount;
        return $newBalance;
    }


    public function getTransactionInfo(): string {
        return 'TRANSFER_TRANSACTION';
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getDestinationAccount(): BankAccountInterface {
        return $this->destinationAccount;
    }

    public function setDestinationAccount(BankAccountInterface $destinationAccount): void {
        $this->destinationAccount;
    }
}

?>