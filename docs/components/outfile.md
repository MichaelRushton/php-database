# PHP Database

[Go back](../statements/select.md)

## `Outfile`

```php
use MichaelRushton\Database\SQL\Components\Outfile;

$stmt->intoOutfile('/path/to/file', function (Outfile $outfile)
{

});
// SELECT ... INTO OUTFILE '/path/to/file'
```

#### `characterSet`

```php
$outfile->characterSet('utf8mb4');
// SELECT ... INTO OUTFILE '/path/to/file' CHARACTER SET utf8mb4
```

#### `fieldsTerminatedBy`

```php
$outfile->fieldsTerminatedBy(',');
// SELECT ... INTO OUTFILE '/path/to/file' FIELDS TERMINATED BY ','
```

#### `fieldsEnclosedBy`

```php
$outfile->fieldsEnclosedBy('"');
// SELECT ... INTO OUTFILE '/path/to/file' FIELDS ENCLOSED BY '"'
```

#### `fieldsOptionallyEnclosedBy`

```php
$outfile->fieldsOptionallyEnclosedBy('"');
// SELECT ... INTO OUTFILE '/path/to/file' FIELDS OPTIONALLY ENCLOSED BY '"'
```

#### `fieldsEscapedBy`

```php
$outfile->fieldsEscapedBy('\\');
// SELECT ... INTO OUTFILE '/path/to/file' FIELDS ESCAPED BY '\'
```

#### `linesStartingBy`

```php
$outfile->linesStartingBy('');
// SELECT ... INTO OUTFILE '/path/to/file' LINES STARTING BY ''
```

#### `linesTerminatedBy`

```php
$outfile->linesTerminatedBy('\n');
// SELECT ... INTO OUTFILE '/path/to/file' LINES TERMINATED BY '\n'
```
