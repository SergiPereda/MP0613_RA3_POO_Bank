<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount implements BankAccountInterface {
    use AmountValidationTrait;

    private float $balance;
    private string $status;
    private OverdraftInterface $overdraft;
    private string $email = '';

    public function __construct(float $balance, ?string $email = null) {
        $this->validateAmount($balance);
        if ($email !== null) {
            $this->setEmail($email);
        }
        $this->balance = $balance;
        $this->status = self::STATUS_OPEN;
        $this->overdraft = new NoOverdraft();

    }


    public function transaction(BankTransactionInterface $bankTransaction): void {
        if (!$this->isOpen()) {
            throw new BankAccountException('Account is closed');
        }
        try {
            $newBalance = $bankTransaction->applyTransaction($this);
            $this->setBalance($newBalance);
        } catch (InvalidOverdraftFundsException $ex){
            throw new FailedTransactionException($ex->getMessage());
        }
        
    }

    public function isOpen(): bool {
        return $this->status === self::STATUS_OPEN;
    }

    public function reopenAccount(): void {
        if ($this->isOpen()) {
            throw new BankAccountException("Account is already open.");
        }
        $this->status = self::STATUS_OPEN;
    }
    public function closeAccount(): void {
        if (!$this->isOpen()) {
            throw new BankAccountException("Account is already closed.");
        }
        $this->status = self::STATUS_CLOSED;
    }

    public function getBalance(): float {
        return $this->balance;
    }
    public function setBalance(float $balance): void {
        $this->balance = $balance;
    }


    public function getOverdraft(): OverdraftInterface {
        return $this->overdraft;
    }

    public function applyOverdraft(OverdraftInterface $overdraft): void {
        $this->overdraft = $overdraft;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->validateEmail($email);
        $this->email = $email;
    }


}
