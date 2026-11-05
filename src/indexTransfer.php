<?php 

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Transactions\TransferTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Exceptions\InvalidArgsException;

require_once 'bootstrap.php';

pl('--------- Balance transfer Test ----------');

$originAccount = new BankAccount(500.0);
$destAccount = new BankAccount(200.0);

pl('Source Account Balance: ' . $originAccount->getBalance());

pl('Destination Account Balance: ' . $destAccount->getBalance());

$originAccount = new TransferTransaction(100, $destAccount);

pl('Transfer Amount: ' . $originAccount->getAmount());

pl('Source Balance After Transaction: ' . $originAccount->getBalance());

pl('Destination Account After Transaction: ' . $destAccount->getBalance());

?>