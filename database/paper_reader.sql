-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-13 10:13:45
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `paper_reader`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `papers`
--

CREATE TABLE `papers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` mediumtext NOT NULL,
  `content` mediumtext NOT NULL,
  `view_flag` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `papers`
--

INSERT INTO `papers` (`id`, `user_id`, `title`, `abstract`, `content`, `view_flag`) VALUES
(1, 1, 'Convolutional Neural Networkを用いた複数種害獣検出', '本論文では，害獣検出のための3DCGモデルを用いたData Augmentationを提案する．害獣による農作物被害は，農家にとって大きな問題となっている．害獣による農作物被害は農家のモチベーションを低下させ，耕作放棄地の増加につながっている．耕作放棄地の増加は害獣の増加の要因となる，結果として害獣被害の増加につながる．そのため我々の研究室では機械学習を用いて害獣を検知し，音と光の効果で撃退するシステムを開発している．しかしCNNなどの深層学習技術を用いて精度の高い物体検出を行うためには、大量の学習画像が必要となる．本研究では3Dモデルを作成し，背景画像を生成することで解決する．結果として65%の精度の精度を得ることができた．', '1. はじめに\r\n害獣による農作物の被害は農家の人々の大きな問題となっている.例として平成 30 年度の害獣による農作物被害は 158 億円と膨大である[1].また,害獣推定生息個体数も上昇しており,例としてイノシシは 1989 年から 2017 年の 29 年で約 60 万頭増加している[1].それにより,農業従事者の営農意欲の低下,耕作放棄・離農の増加といった被害額以上に大きな影響を与えている.害獣被害への対策として,電気柵の設置が行われているが,感電事故も報告されており,安全面において問題が生じている.またこのような侵入防止策による対策では,導入コストや運用コストが増大するといった問題も生じている.そのため,害獣対策には安全性の確保とコストの削減が求められており,これらの問題の対策が求められている.そこで我々の研究グループでは画像認識技術を用いた害獣忌避システムの開発に取り組んでいる.\r\n本システムは機械学習を用いて害獣を検出し,音響や照明明滅で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmentation を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.\r\n2.3DCG モデルを用いた Data Augmentation\r\n本稿で提案する Data Augmentation 手法は,害獣の3DCG モデルを実画像に合成して,学習画像を生成するものである.本研究では Smoothie-3D を用いて 3Dモデルを作成し,そのモデルに対して任意の回転,拡大・縮小を加え,実画像に重畳する.これによって,イノシシ,シカの学習用画像データセットを効率的に構築することができる.本手法を用いて生成した画像で学習したモデルにより,実害獣画像の高精度な識別が可能である[2].\r\n3.MobileNetSSD\r\n3.1 SSD(Single Shot MultiBox Detector)\r\nSSD は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.\r\n3.2 MobileNet\r\nMobileNet とはエッジデバイスなどのリソースが限られた端末でも高速に処理が可能な軽量なCNNである.MobileNet は,第 1 層以外は標準的な畳み込みではなく,depthwise separable convolutions を利用している.depthwise separable convolutions とは depthwise convolution と pointwise convolution の 2 つを組み合わせた畳み込みである.前者は特徴マップのチャネル毎にそれぞれ独立して空間方向の畳み込みを行い,後者はチャネル方向の畳み込みを行う.通常の畳み込みが 1 回で行うことを 2 つに分けることで計算コストを大幅に削減できる.\r\n4. データセット構築\r\n物体検出を行うネットワークモデルでは,学習のために画像と物体名と物体が映り込んでいる範囲などの情報が記載されているアノテーション情報が必要とされる.本研究では,害獣の 3DCG モデルを実背景画像に重畳することで学習用データセットを作成するが,一枚ごとに人間が手作業で重畳し,アノテーション情報を付与するのは膨大な手間と時間を要する.そこで,作業効率の改善を行うために,アノテーション情報の作成を補助するプログラムを作成した.本研究では背景画像に対して重畳する領域,重畳する 3DCG モデルの大きさの 2 つのデータを付与する領域指定プログラムと,その情報をもとに 3DCGモデルを重畳し,アノテーション情報を付与する3DCG モデルを重畳し,アノテーション情報を付与する 3DCG モデル重畳プログラムの 2 種類のプログラムを作成した.本プログラムを用いて各クラス 5,000枚,計 10,000 枚の学習用画像とアノテーション情報を作成した.実験用画像データセットは検索エンジンを用いて各クラスの実害獣を収取した.それによりイノシシの画像を 83 枚,シカの画像を 88 枚,各物体数 100 体用意した．\r\n5. 検出実験\r\n5.1 実験条件\r\n4.で生成したデータセットを用いて MobileNetSSD の学習及び検出実験を行い,検出性能を評価した.本研究では ImageNet で学習済みのモデルを用いて転移学習を行う.転移学習とは元のモデルから最終層の出力サイズのみを変更し,学習済みモデルの重みを各層の重みの初期値として学習を行う手法である.学習の条件としてバッチサイズは 16 とし,最適化手法にはモーメンタムSGD を用いた.学習率は 0.001,モーメンタムは 0.9と設定して 600Epoch まで学習を行った.\r\n5.2 実験結果および考察\r\n表 1 に実験結果を示す.TP は検出対象を検出できており,クラスも正しい場合(正答画像),FP は検出できているがクラスは異なる場合(誤検出),FN は検出対象を検出できていない場合(未検出)をそれぞれ指す.結果より検出率は73%,シカが57%の平均65%となっている.\r\n図 1 に検出結果の例を示す.(a)に正答,(b)に誤検出,(c)には未検出の結果を示している.また上段にイノシシ,下段にシカの検出結果を示している.(a)について,どちらの画像も対象を検出できていることがわかる.またイノシシの画像では,検出対象が複数いる場合でも,対象ごとに検出できていることがわかる.(b)について,上段の画像は,イノシシが正面を向いており,前方に屈んだシカと酷似しているため,誤検出したと考えられる.対して下段の画像は,シカがカメラに対して背中を向けており,イノシシとの大きな差である頭や首が映り込んでいないため,胴体をもとにイノシシと誤検出したと考えられる.(c)について,上段のイノシシは川を泳いでおり,下段のシカは首を大きく内側に曲げている.どちらも生成した学習用画像にはない姿勢をしていることから検出できなかったと考えられる.以上のことから,対象が正面や後方を向いた学習用画像を増加させることと横からだけでなく斜め上から見下ろしたような画像を増加させる,3DCG モデルの姿勢を変化させるなど,現在生成していないパターンの学習用画像を生成すれば誤検出,未検出の画像に対しても正しい検出が可能になると考えられる.\r\n5.3 処理時間計測実験\r\n本システムはリアルタイムでの運用を想定しているため,高速な処理が求められる.そこで本システムの処理時間の計測実験を行った.計測実験ではイノシシ,シカが撮影された動画をそれぞれ 2 つ用意して実験を行った.結果として全体の平均は HD の場合は約 54FPS,フル HD の場合は約 40FPS となっており,リアルタイムに検出が可能であることが確認できた.\r\n6. おわりに\r\n本稿では,3DCG モデルを用いた Data Augmentationを提案し,本手法で学習済みの MobileNetSSD を用いた複数種害獣検出の精度検証を行った.今後の課題として,検出精度を向上させるために,3DCG モデルに動きを加えるなど,学習用画像のバリエーションを増やすことが挙げられる.\r\n参考文献\r\n[1] 農林水産省 農村復興局,“鳥獣被害の現状と対策(令和3 年 10月)”,https://www.maff.go.jp/\nj/seisan/tyozyu/higai/attach/pdf/in-dex351.pdf\r\n[2] Naoya Ryoke, Hironori Kitakaze, Ryo Matsumura.: “Data Augmentation with 3DCG Models for Nuisance Wildlife Detection using a Convolutional Neural Network,” Proceedings of the 8th IIAE International Conference on Intelligent Systems and Image Processing 2021, pp.179-185, 2021.', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `paper_authers`
--

CREATE TABLE `paper_authers` (
  `id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `auther_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `paper_authers`
--

INSERT INTO `paper_authers` (`id`, `paper_id`, `user_id`, `auther_name`) VALUES
(1, 1, 1, '領家直哉'),
(2, 1, -1, '北風裕教'),
(3, 1, -1, '松村遼');

-- --------------------------------------------------------

--
-- テーブルの構造 `paper_comments`
--

CREATE TABLE `paper_comments` (
  `id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext DEFAULT NULL,
  `anchor_node` text NOT NULL,
  `anchor_offset` int(11) NOT NULL,
  `focus_node` text NOT NULL,
  `focus_offset` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `paper_comments`
--

INSERT INTO `paper_comments` (`id`, `paper_id`, `user_id`, `comment`, `anchor_node`, `anchor_offset`, `focus_node`, `focus_offset`) VALUES
(1, 1, 1, 'single', '\nSSD は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.', 1, '\nSSD は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.', 4),
(2, 1, 1, '賢い', '\n2.3DCG モデルを用いた Data Augmentation', 16, '\n2.3DCG モデルを用いた Data Augmentation', 33),
(3, 1, 1, 'ngo', ' は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.', 296, ' は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.', 308),
(4, 1, 1, 'ngo', ' は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.', 296, ' は One Stage Detector と呼ばれる 1 度の CNNの演算で物体の「物体候補領域検出」と「クラス分類」を行う手法であり,Regions with CNN のような Two Stage Detector と比較すると高速であるという利点がある.SSD のネットワークは VGG-16 といった既存の CNN の構造をベースネットワークとして流用し,最後の全結合層に新たな畳み込み層を加えた構造となっている.物体検出を行うときは,各特徴マップでクラス特徴量と位置特徴量を算出する.そして各畳み込み層で違うスケールで物体検出を行い,各層からの検出結果を Non Maximum Suppression を用いて統合する.各層で大きさの違う特徴量を使っているため,様々な大きさに対応した物体検出が可能となっている.しかし通常の CNN モデルをベースとしたSSD では高性能な GPU を搭載しなければリアルタイムで検出を行うことが困難である.我々が開発している害獣忌避システムは,害獣被害の対象となる田や畑,害獣が生息している山間部での設置を想定しているため,電源確保が困難である.そこで,ソーラーパネルによって充電可能なポータブルバッテリーを電源に用いる.しかしポータブルバッテリーの容量では,高性能なコンピュータを利用することができないため,コンピュータには低消費電力であるJetson nano を用いる.よって本研究ではエッジデバイスなどリソースが限られた端末でも高速に処理可能な MobileNet ベースの SSD を用いる.', 308),
(5, 1, 1, 'なぞハイフン', '\n本システムは機械学習を用いて害獣を検出し,音響や照明明滅で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmenta-tion を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.', 216, '\n本システムは機械学習を用いて害獣を検出し,音響や照明明滅で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmenta-tion を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.', 217),
(6, 0, 1, '', '', 0, '', 0),
(7, 1, 1, 'すごい', '\n本稿で提案する Data Augmentation 手法は,害獣の3DCG モデルを実画像に合成して,学習画像を生成するものである.本研究では Smoothie-3D を用いて 3Dモデルを作成し,そのモデルに対して任意の回転,拡大・縮小を加え,実画像に重畳する.これによって,イノシシ,シカの学習用画像データセットを効率的に構築することができる.本手法を用いて生成した画像で学習したモデルにより,実害獣画像の高精度な識別が可能である[2].', 109, '\n本稿で提案する Data Augmentation 手法は,害獣の3DCG モデルを実画像に合成して,学習画像を生成するものである.本研究では Smoothie-3D を用いて 3Dモデルを作成し,そのモデルに対して任意の回転,拡大・縮小を加え,実画像に重畳する.これによって,イノシシ,シカの学習用画像データセットを効率的に構築することができる.本手法を用いて生成した画像で学習したモデルにより,実害獣画像の高精度な識別が可能である[2].', 120),
(8, 1, 1, '��x�łł���̂�����', ' �� One Stage Detector �ƌĂ΂�� 1 �x�� CNN�̉��Z�ŕ��̂́u���̌��̈挟�o�v�Ɓu�N���X���ށv���s����@�ł���,Regions with CNN �̂悤�� Two Stage Detector �Ɣ�r����ƍ����ł���Ƃ������_������.SSD �̃l�b�g���[�N�� VGG-16 �Ƃ����������� CNN �̍\�����x�[�X�l�b�g���[�N�Ƃ��ė��p��,�Ō�̑S�����w�ɐV���ȏ�ݍ��ݑw���������\���ƂȂ��Ă���.���̌��o���s���Ƃ���,�e�����}�b�v�ŃN���X�����ʂƈʒu�����ʂ��Z�o����.�����Ċe��ݍ��ݑw�ňႤ�X�P�[���ŕ��̌��o���s��,�e�w����̌��o���ʂ� Non Maximum ', 28, ' �� One Stage Detector �ƌĂ΂�� 1 �x�� CNN�̉��Z�ŕ��̂́u���̌��̈挟�o�v�Ɓu�N���X���ށv���s����@�ł���,Regions with CNN �̂悤�� Two Stage Detector �Ɣ�r����ƍ����ł���Ƃ������_������.SSD �̃l�b�g���[�N�� VGG-16 �Ƃ����������� CNN �̍\�����x�[�X�l�b�g���[�N�Ƃ��ė��p��,�Ō�̑S�����w�ɐV���ȏ�ݍ��ݑw���������\���ƂȂ��Ă���.���̌��o���s���Ƃ���,�e�����}�b�v�ŃN���X�����ʂƈʒu�����ʂ��Z�o����.�����Ċe��ݍ��ݑw�ňႤ�X�P�[���ŕ��̌��o���s��,�e�w����̌��o���ʂ� Non Maximum ', 66),
(9, 1, 1, 'これって実際に効果あるの？', '\n本システムは機械学習を用いて害獣を検出し,音響や照明明滅で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmentation を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.', 22, '\n本システムは機械学習を用いて害獣を検出し,音響や照明明滅で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmentation を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.', 29),
(10, 1, 1, 'てｓ', 'で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmentation を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.', 12, 'で忌避効果を与えることで害獣対策の安全性の向上とコストの削減を図るものである.機械学習において高精度に物体検出を行うには大量の学習用画像が必要となる.しかしながら本システムでの検出対象である,イノシシやシカといった害獣は愛玩動物のように,機械学習用のデータセットが公開されておらず,画像の収集が困難である.そこで本稿では 3DCG モデルを用いた Data Augmentation を提案する.本手法で生成した学習用画像を用いて Convolutional Neural Network (CNN)の学習が可能であること及び実際の害獣の検出が可能であるか検証を行う.', 16),
(11, 1, 1, 'んご', 'で忌避効果を与えることで', 12, '害獣対策', 2),
(12, 1, 1, '', '投稿', 1, '投稿', 1),
(13, 1, 1, '', '投稿', 1, '投稿', 1),
(14, 1, 1, '', 'コメント入力', 6, '投稿', 2),
(15, 1, 1, '', '投稿', 1, '投稿', 1),
(16, 1, 1, '', '投稿', 1, '投稿', 1),
(17, 1, 1, 'どの手法', '投稿', 1, '投稿', 1),
(18, 1, 1, '学習用画像', '\n本稿で提案する Data Augmentation 手法は,害獣の3DCG モデルを実画像に合成して,学習画像を生成するものである.本研究では Smoothie-3D を用いて 3Dモデルを作成し,そのモデルに対して', 52, '\n本稿で提案する Data Augmentation 手法は,害獣の3DCG モデルを実画像に合成して,学習画像を生成するものである.本研究では Smoothie-3D を用いて 3Dモデルを作成し,そのモデルに対して', 56);

-- --------------------------------------------------------

--
-- テーブルの構造 `search_term_translator`
--

CREATE TABLE `search_term_translator` (
  `id` int(11) NOT NULL,
  `abbreviation` varchar(255) NOT NULL,
  `expansion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `search_term_translator`
--

INSERT INTO `search_term_translator` (`id`, `abbreviation`, `expansion`) VALUES
(1, 'CNN', 'Convolutional Neural Network');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permission` varchar(50) NOT NULL,
  `affiliation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permission`, `affiliation`) VALUES
(1, 'naochin', 'ngo@ngo.com', '$2y$10$vK1UYUnChBVsQh/842WqiuLgg.ckKKeI0HmhxTDMTL5a1NyX6cnm6', 'admin', 'kyutech'),
(2, 'naoya', 'naoya@ngo.com', '$2y$10$s9xZnIqxbXTiWWlMCZRjD.fUEuK2W/J6MRm4i2IryUIucPnYpEmzu', 'develop', 'athome'),
(3, 'yukine', 'yukine@ngo.com', '$2y$10$qLenqUFan1ObeAZS6fDAf.PyA3dWPfl6UMzdA20abtglcIKpisGiK', 'viewer', 'O-NITC'),
(4, 'waru', 'waru@ngo.com', '$2y$10$q.Aaqth8PtMe7HpAH3VA.Or7ZdMyTnbJuOoCM2vqTVnZsCL.wvUeO', 'viewer', 'O-NITC');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `paper_authers`
--
ALTER TABLE `paper_authers`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `paper_comments`
--
ALTER TABLE `paper_comments`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `search_term_translator`
--
ALTER TABLE `search_term_translator`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `paper_authers`
--
ALTER TABLE `paper_authers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `paper_comments`
--
ALTER TABLE `paper_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `search_term_translator`
--
ALTER TABLE `search_term_translator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
