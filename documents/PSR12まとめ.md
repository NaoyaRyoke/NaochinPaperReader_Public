# PSR12で聞いたことを書き留めるページ
講師：chatgpt
## コメント
1. ファイル冒頭のコメント
- ファイルの冒頭にあるコメントはファイル全体に関する説明を行うために使用する．
> 例：ファイルの目的やライセンス情報など
```
<?php
/**
 * This file is part of the Acme package.
 *
 * (c) John Doe <john.doe@example.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

```
2. クラスやインターフェース
- クラスやインターフェースの定義の前に，その目的や使用方法を説明するコメントを追加する
```
/**
 * This class handles user authentication.
 */
class UserAuthenticator
{
    // ...
}

```
3. メソッドや関数のコメント
- メソッドや関数の定義の前に，その役割や引数，戻り値を説明するコメントを追加する
```
/**
 * Authenticates a user.
 *
 * @param string $username The username of the user.
 * @param string $password The password of the user.
 * @return bool True if authentication is successful, false otherwise.
 */
public function authenticate(string $username, string $password): bool
{
    // ...
}

```
4. インラインコメント
- コードの中に埋め込まれるコメントで，特定のコードの動作を説明する．通常は一行のコメントとして記述される
```
$user = new User();

// Check if the user is active
if ($user->isActive()) {
    // ...
}

```
5. 複数行のコメント
- 長い説明が必要な場合は複数行にわたるコメントを使用する
```
/*
 * This block of code handles the connection to the database.
 * It ensures that the connection is established and
 * handles any potential exceptions.
 */
try {
    $db = new DatabaseConnection();
} catch (Exception $e) {
    // Handle exception
}
```
## this演算子について
PSR-12には$this演算子に関する直接的な規定はない

しかしコードの可読性と一貫性の観点から一般的には，インスタンスメソッドやプロパティへのアクセス時には$thisを使用することが推奨される．

## 関数や制御構造の中括弧の位置
1. クラスやメソッド
- クラスやメソッドの中括弧はメソッドの宣言のあと改行したのちに挿入される
```
class ExampleClass
{
    public function exampleMethod()
    {
        // メソッドの内容
    }
}

```
2. 制御構造
- if文，for文といった制御構造は宣言のあと空白を入れ，中括弧を挿入した後に改行を行う
> else文など連続した制御構文は閉じ括弧の後ろに挿入する
```
if ($condition) {
    // 条件が真の場合の処理
} elseif ($anotherCondition) {
    // 別の条件が真の場合の処理
} else {
    // いずれの条件も真でない場合の処理
}

for ($i = 0; $i < 10; $i++) {
    // ループの内容
}

while ($condition) {
    // ループの内容
}

switch ($variable) {
    case 'value1':
        // case 'value1' の処理
        break;
    case 'value2':
        // case 'value2' の処理
        break;
    default:
        // どの case にも一致しない場合の処理
        break;
}

```
3. 命名規則
    1. クラス：StudyCaps
    2. メソッド，プロパティ，関数：camelCase
    3. 定数：大文字で単語間をアンダースコアで区切る
