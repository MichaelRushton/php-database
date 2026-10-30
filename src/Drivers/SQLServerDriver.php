<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Interfaces\DriverInterface;
use SensitiveParameter;

class SQLServerDriver implements DriverInterface
{
    public protected(set) string $dsn;
    public protected(set) string $savepoint = 'SAVE TRANSACTION';
    public protected(set) string $roll_back_to = 'ROLLBACK TRANSACTION';

    public function __construct(
        public protected(set) ?string $username = 'sa',
        #[SensitiveParameter]
        public protected(set) ?string $password = null,
        public protected(set) string $Server = '',
        public protected(set) ?string $AccessToken = null,
        public protected(set) ?string $APP = null,
        public protected(set) ?string $ApplicationIntent = null,
        public protected(set) ?string $AttachDBFileName = null,
        public protected(set) ?string $Authentication = null,
        public protected(set) ?string $ColumnEncryption = null,
        public protected(set) ?bool $ConnectionPooling = null,
        public protected(set) ?int $ConnectRetryCount = null,
        public protected(set) ?int $ConnectRetryInterval = null,
        public protected(set) ?string $Database = null,
        public protected(set) ?string $Driver = null,
        public protected(set) ?bool $Encrypt = null,
        public protected(set) ?string $Failover_Partner = null,
        public protected(set) ?string $KeyStoreAuthentication = null,
        public protected(set) ?string $KeyStorePrincipalId = null,
        public protected(set) ?string $KeyStoreSecret = null,
        public protected(set) ?string $Language = null,
        public protected(set) ?string $LoginTimeout = null,
        public protected(set) ?bool $MultipleActiveResultSets = null,
        public protected(set) ?string $MultiSubnetFailover = null,
        public protected(set) ?bool $QuotedId = null,
        public protected(set) ?string $Scrollable = null,
        public protected(set) ?string $TraceFile = null,
        public protected(set) ?bool $TraceOn = null,
        public protected(set) ?string $TransactionIsolation = null,
        public protected(set) ?string $TransparentNetworkIPResolution = null,
        public protected(set) ?bool $TrustServerCertificate = null,
        public protected(set) ?string $WSID = null,
        public protected(set) ?array $pdo_options = null
    ) {

        $this->dsn = 'sqlsrv:' . implode(';', array_filter([
            "Server=$Server",
            isset($AccessToken) ? "AccessToken=$AccessToken" : '',
            isset($APP) ? "APP=$APP" : '',
            isset($ApplicationIntent) ? "ApplicationIntent=$ApplicationIntent" : '',
            isset($AttachDBFileName) ? "AttachDBFileName=$AttachDBFileName" : '',
            isset($Authentication) ? "Authentication=$Authentication" : '',
            isset($ColumnEncryption) ? "ColumnEncryption=$ColumnEncryption" : '',
            isset($ConnectionPooling) ? "ConnectionPooling=" . (int) $ConnectionPooling : '',
            isset($ConnectRetryCount) ? "ConnectRetryCount=$ConnectRetryCount" : '',
            isset($ConnectRetryInterval) ? "ConnectRetryInterval=$ConnectRetryInterval" : '',
            isset($Database) ? "Database=$Database" : '',
            isset($Driver) ? "Driver=$Driver" : '',
            isset($Encrypt) ? "Encrypt=" . (int) $Encrypt : '',
            isset($Failover_Partner) ? "Failover_Partner=$Failover_Partner" : '',
            isset($KeyStoreAuthentication) ? "KeyStoreAuthentication=$KeyStoreAuthentication" : '',
            isset($KeyStorePrincipalId) ? "KeyStorePrincipalId=$KeyStorePrincipalId" : '',
            isset($KeyStoreSecret) ? "KeyStoreSecret=$KeyStoreSecret" : '',
            isset($Language) ? "Language=$Language" : '',
            isset($LoginTimeout) ? "LoginTimeout=$LoginTimeout" : '',
            isset($MultipleActiveResultSets) ? "MultipleActiveResultSets=" . (int) $MultipleActiveResultSets : '',
            isset($MultiSubnetFailover) ? "MultiSubnetFailover=$MultiSubnetFailover" : '',
            isset($QuotedId) ? "QuotedId=" . (int) $QuotedId : '',
            isset($Scrollable) ? "Scrollable=$Scrollable" : '',
            isset($TraceFile) ? "TraceFile=$TraceFile" : '',
            isset($TraceOn) ? "TraceOn=" . (int) $TraceOn : '',
            isset($TransactionIsolation) ? "TransactionIsolation=$TransactionIsolation" : '',
            isset($TransparentNetworkIPResolution) ? "TransparentNetworkIPResolution=$TransparentNetworkIPResolution" : '',
            isset($TrustServerCertificate) ? "TrustServerCertificate=" . (int) $TrustServerCertificate : '',
            isset($WSID) ? "WSID=$WSID" : '',
        ]));

    }
}
