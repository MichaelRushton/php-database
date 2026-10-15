<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Drivers;

use MichaelRushton\Database\Driver;
use SensitiveParameter;

readonly class SQLServerDriver extends Driver
{
    public function __construct(
        public ?string $username = 'sa',
        #[SensitiveParameter]
        public ?string $password = null,
        public string $Server = '',
        public ?string $AccessToken = null,
        public ?string $APP = null,
        public ?string $ApplicationIntent = null,
        public ?string $AttachDBFileName = null,
        public ?string $Authentication = null,
        public ?string $ColumnEncryption = null,
        public ?bool $ConnectionPooling = null,
        public ?int $ConnectRetryCount = null,
        public ?int $ConnectRetryInterval = null,
        public ?string $Database = null,
        public ?string $Driver = null,
        public ?bool $Encrypt = null,
        public ?string $Failover_Partner = null,
        public ?string $KeyStoreAuthentication = null,
        public ?string $KeyStorePrincipalId = null,
        public ?string $KeyStoreSecret = null,
        public ?string $Language = null,
        public ?string $LoginTimeout = null,
        public ?bool $MultipleActiveResultSets = null,
        public ?string $MultiSubnetFailover = null,
        public ?bool $QuotedId = null,
        public ?string $Scrollable = null,
        public ?string $TraceFile = null,
        public ?bool $TraceOn = null,
        public ?string $TransactionIsolation = null,
        public ?string $TransparentNetworkIPResolution = null,
        public ?bool $TrustServerCertificate = null,
        public ?string $WSID = null,
        public ?array $pdo_options = null
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
