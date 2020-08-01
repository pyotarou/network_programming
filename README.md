# network_programming
ネットワークプログラミングの授業で作成したWebアプリです。

## login.html
登録したユーザ情報を入力するとログインすることができます。

## entry.html
ユーザ情報（ID・パスワード）を登録できます。
DBはmariaDBを利用しています。

## php/index.php
メインのページです。
### ルート検索
このページではGoogleMapAPIを利用したルート検索をすることができます。
出発地と到着地を入力してからルート検索を押すと、検索が実行されます。

### 検索履歴
検索した履歴はデータベース内に保存され、履歴は画面の左下に常に表示されています。

### 履歴共有
また、検索履歴を他のユーザに共有することが出来ます。共有するためには「履歴を共有」ボタンを押し、共有したいユーザのIDを入力すると共有することが出来ます。

### ログアウト
右上の「ログアウト」ボタンを押すとログアウトできます。
