# なおちんろんぶんりーだー
論文管理アプリ
名前案（paper chat）

## スライドはこちら
https://docs.google.com/presentation/d/1O9YZFlZLXWOCJGQQi_iBP7lK-uFuD_-x/edit?usp=sharing&ouid=116260502751510462926&rtpof=true&sd=true

## Next Task
- 管理者画面系は階層を分ける
- インラインコメント表示にはbxsliderが必要？
- インラインコメントをクリックしたら，表示欄に表示されるようにする

## インラインコメントの返信について
- データベース側にコメントID持たせれば行ける気がしてきた．

|id|commnet_id|user_id|comment|
|--|--|--|--|
|1|1|1|ngo|
|2|2|2|ngongo|
|3|1|1|ngohoge|
|4|1|3|ngohoge|
|5|2|1|ngongo|


## 管理者
- ユーザーアカウントの削除，権限の変更
- 不正論文の削除
- データの出力

## ユーザー
- アカウント作成
- 論文投稿
- （論文を投稿した人のみ）コメントの削除，要約の変換
- 要約出力
- ↑翻訳
- コメント
- インラインごとにコメントできるようにして，それに対して返信できる形にしたい
- （コメントを投稿した人）コメントの削除


## 作業の流れ（基本的には一緒にやりましょう）
### Issueの作成（githubのwebページで）
### ブランチの作成（githubのwebページで）
### ブランチの更新（vscodeで）
```
git fetch
git checkout (ブランチ名)
```

## 1日の流れ
### 始業時：gitの更新
更新の確認（vscodeでやってもいいよ）
```
git fetch 
```
（何も問題無ければ）gitの更新（vscodeでもいいよ）
```
git pull
```

### 昼食後：進捗確認
領家さんが一人ずつに進捗を聞きます．

### 終業時：gitの更新
現在までの進捗をgitに挙げる（vscodeでやってもいいよ）
```
git add (更新したファイル)
```
```
git commit -m "コミットメッセージ"
```
```
git push 
```
or
```
git push origin (branch名)
```

## ルール策定
- 15分わからなかったら聞く
- 休憩は挙手
- データベースの列の追加を領家に一報ください

## アーカイブ
## インラインコメントについて
1. 選択範囲の検出
多分jsのmousedownとmouseup使えば行ける
2. コメントの追加の表示（極論右側にコメント追加ボタン書けば行けるようにすればいい？）
いい感じに動的に取る
3. コメント追加処理
選択されたテキストや位置情報を取得し，データベースに追加する
4. インラインコメントの表示
選択されたテキストの近くに行くと，コメントを閲覧できるようにする．

もしくは，右側にインラインテキスト表示用のボックス用意する？



## github
https://github.com/mminegishi28/movie

https://github.com/kyoei77/ChineseFood

https://github.com/re-shimomura/tripmemory
