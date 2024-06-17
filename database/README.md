# データベースのテストケース
## users
|id|username|email|password|permission|
|--|--|--|--|--|
|1|naochin|ngo@ngo.com|1234|admin|
|2|naoya|naoya@ngo.com|7890|develop|
|3|yukine|yukine@ngo.com|aiueo|viewer|
|4|waru|waru@ngo.com|waru|viewer|

- id:auto_increment
- other : not null

## papers
|id|user_id|title|abstruct|content|
|--|--|--|--|--|
|1|1|省略|省略|省略|
|2|2|省略|省略|省略|
|3|1|省略|省略|省略|

- id:auto_increment
- other : not null

## paper_authers
|id|paper_id|user_id|name|
|--|--|--|--|
|1|1|1|領家直哉|
|2|1|-1|北風裕教|
|3|1|-1|松村遼|
|4|2|2|領家直哉|
|5|2|-1|Nazmun Nahid|
|6|2|-1|井上創造|
|7|3|1|Naoya Ryoke|
|8|3|-1|Hironori Kitakaze|
|9|3|-1|Ryo Matsumura|

