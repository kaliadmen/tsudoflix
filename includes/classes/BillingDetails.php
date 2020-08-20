<?php
    class BillingDetails {
        public static function insert_details(PDO $connection, \PayPal\Api\Agreement $agreement, string $token, string $username) : bool {
            $query = $connection->prepare("INSERT INTO billing_details (agreement_id, next_billing_date, token, username) VALUES (:agreementId, :billingDate, :token, :uname)");

            $agreement_details = $agreement->getAgreementDetails();

            $query->bindValue(":agreementId", $agreement->getId());
            $query->bindValue(":billingDate", $agreement_details->getNextBillingDate());
            $query->bindValue(":token", $token);
            $query->bindValue(":uname", $username);

            return $query->execute();
        }
    }