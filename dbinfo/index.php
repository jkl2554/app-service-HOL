<?php
$dbhost = "";
$dbport = "";
$dbname = "";
$username = "";
$password = "";
$connectionName = "localdb";
if (!empty($_GET["dbconn"])) {
    $connectionName = $_GET["dbconn"];
}
file_put_contents('data/' . $_POST['title'], $_POST['description']);
// Parsing connnection string
$value = getenv("MYSQLCONNSTR_" . $connectionName);
if (!empty($value)) {
    $dbhost = preg_replace("/^.*Data Source=(.+?):.*$/", "\\1", $value);
    $dbport = preg_replace("/^.*:(.+?);.*$/", "\\1", $value);
    $dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $username = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $password = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
    echo "<div>
<pre><code>
DB_CONNECTION=mysql
DB_HOST=" . $dbhost . "
DB_PORT=" . $dbport . "
DB_DATABASE=" . $dbname . "
DB_USERNAME=" . $username . "
DB_PASSWORD=" . $password . "
</code></pre></div>
";
} else {
    echo "<h1>" . $connectionName . " is Not Connected</h1>";
}
