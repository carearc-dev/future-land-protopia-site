<?php
// ================= 初期設定 =================
$errors = [];
$success = false;

// ================= 送信処理 =================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $required = ["name", "kana", "email", "tel", "message", "agree"];
  foreach ($required as $value) {
    if (empty($_POST[$value])) {
      $errors[] = "必須項目をすべて入力し、プライバシーポリシーに同意してください。";
      break;
    }
  }

  if (empty($errors)) {
    $name    = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
    $kana    = htmlspecialchars($_POST["kana"], ENT_QUOTES, "UTF-8");
    $email   = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
    $tel     = htmlspecialchars($_POST["tel"], ENT_QUOTES, "UTF-8");
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES, "UTF-8");
    $type    = htmlspecialchars($_POST["type"] ?? "未選択", ENT_QUOTES, "UTF-8");

    $to = "n.nishimaki@carearc.co.jp"; // ★自分のメールに変更 ★複数アドレス設定可能 ★,で区切る
    $subject = "【お問い合わせ】ホームページよりお問い合わせがありました。";
    $body = <<<EOT
【お問い合わせ種別】
{$type}

【お名前】
{$name}

【フリガナ】
{$kana}

【メールアドレス】
{$email}

【電話番号】
{$tel}

【お問い合わせ内容】
{$message}
EOT;

    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    if (mb_send_mail($to, $subject, $body, "From: {$email}")) {
      $success = true;
    } else {
      $errors[] = "送信に失敗しました。時間をおいて再度お試しください。";
    }
  }

  // AJAX用にJSONで返す
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
      'success' => $success,
      'errors' => $errors
    ]);
    exit;
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Future Land Protopia</title>
  <link rel="stylesheet" href="css/style.css">

  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hurricane&family=Manrope:wght@200..800&family=Noto+Sans+JP:wght@100..900&family=Zen+Maru+Gothic:wght@400;500;700;900&display=swap" rel="stylesheet">

</head>
<body>

  <!-- ================= Header ================= -->
<header class="header">
  <div class="headerInner">
    <h1 class="logo">
      <a href="#">
        <img src="img/logo.png" alt="">
      </a>
    </h1>

    <!-- PC NAV -->
    <nav class="pcNav">
      <ul>
        <li><img src="img/icon01.png" alt="" class="icon" style="width: 30px; max-width: 100px;"><a href="#concept">Concept</a></li>
        <li><li><img src="img/icon02.png" alt="" class="icon" style="width: 30px; max-width: 100px;"><a href="#characters">Friends</a></li>
        <li><li><img src="img/icon01.png" alt="" class="icon" style="width: 30px; max-width: 100px;"><a href="#stamp">Stamp</a></li>
        <!-- ▼ECグッズ：一時非表示（再開時は style="display:none" を外す） -->
        <li style="display: none;"><img src="img/icon02.png" alt="" class="icon" style="width: 30px; max-width: 100px;"><a href="#goods">Item</a></li>
        <li><li><img src="img/icon01.png" alt="" class="icon" style="width: 30px; max-width: 100px;"><a href="#news">News</a></li>
        <li><li><img src="img/icon02.png" alt="" class="icon" style="width: 30px; max-width: 100px;"><a href="#contact">Contact</a></li>
      </ul>
    </nav>

    <!-- Hamburger -->
    <button class="hamburger menuBtn" aria-label="menu">
      <img src="img/sp-nav-btn.png" alt="" class="menuIcon">
      <span class="menuText">MENU</span>
    </button>
  </div>

  <!-- SP NAV -->
<nav class="spNav">
  <!-- Close Button -->
  <button class="spClose" aria-label="close menu">✕</button>
    <ul>
      <li><img src="img/icon01.png" alt="" class="icon" style="width: 40px; max-width: 100px;"><a href="#concept">Concept</a></li>
      <li><img src="img/icon02.png" alt="" class="icon" style="width: 40px; max-width: 100px;"><a href="#characters">Friends</a></li>
      <li><img src="img/icon01.png" alt="" class="icon" style="width: 40px; max-width: 100px;"><a href="#stamp">Stamp</a></li>
      <!-- ▼ECグッズ：一時非表示（再開時は style="display:none" を外す） -->
      <li style="display: none;"><img src="img/icon02.png" alt="" class="icon" style="width: 40px; max-width: 100px;"><a href="#goods">Item</a></li>
      <li><img src="img/icon01.png" alt="" class="icon" style="width: 40px; max-width: 100px;"><a href="#news">News</a></li>
      <li><img src="img/icon02.png" alt="" class="icon" style="width: 40px; max-width: 100px;"><a href="#contact">Contact</a></li>
    </ul>

        <!-- ★ 追加するキャラクター -->
    <div class="spNav-character">
      <img src="img/Flatty-Anime.gif" alt="character">
    </div>
</nav>
</header>


  <!-- ================= Hero ================= -->
  <div class="hero" id="fv">
    <video src="img/PC-fv.mp4" 100% autoplay muted loop playsinline class="fv-movie PC"></video>
    <video src="img/SP-fv.mp4" 100% autoplay muted loop playsinline class="fv-movie SP"></video>
  </div>

  <!-- ================= Concept ================= -->
  <section class="concept" id="concept">
    <h2 class="section-title js-fadeup"><span class="line">FUTURE LAND PROTOPIA</span></h2>

    <div class="concept-visual">
      <img src="img/concept-img.png" alt="" class="concept-img">
    </div>

    <p class="concept-text js-fadeup">
      “地球にやさしい”<br>
      “人にやさしい”<br>
      人間も動物も共存する美しい地球。<br>
      たったひとつしかない青く輝く地球。<br>
      <br>
      地球の良い未来につなげていくために、<br>
      私たちひとりひとりが身近な視点から<br>
      見つめ直し行動することがとても大切だね。<br>
      <br>
      フラッティと良き仲間より
    </p>
  </section>

  <!-- ================= Characters ================= -->
  <section class="characters" id="characters" style="background-color: #fffdee;">
    <div class="Title-Box">
      <h2 class="section-title1 js-fadeup">FRIENDS</h2>
        <p class="subtitle js-fadeup"><span class="pick" style="color: var(--accent-2);">な</span>かまたち</p>
    </div>

    <p class="PC concept-text js-fadeup" style="margin-bottom: 50px;">
      プロトピアの森に暮らす3人のおともだち。それぞれが「ありがとう」の気持ちを大切にしながら、<br>
      毎日ちいさな幸せを見つけています。お花のようにカラフルでやさしい心をもった彼らが、<br>
      あなたの毎日にそっと彩りを届けてくれるかもしれません。
    </p>

    <p class="SP concept-text js-fadeup" style="margin-bottom: 50px;">
      プロトピアの森に暮らす3人のおともだち。<br>それぞれが「ありがとう」の気持ちを<br>大切にしながら、
      毎日ちいさな幸せを<br>見つけています。お花のようにカラフルで<br>やさしい心をもった彼らが、
      あなたの毎日に<br>そっと彩りを届けてくれるかもしれません。
    </p>

    <div class="character-list">
      <article class="character-card">
        <div class="character-image">
          <img src="img/character01.png" alt="エリオット" class="item js-fadeup-1">
        </div>
        <p class="character-name">Elliot（エリオット）</p>
        <p class="character-copy">やさしくて頼れるくまの子。みん<br>
          なのことをいつも気にかけてくれる、<br>
          優しい存在。</p>
      </article>

      <article class="character-card">
        <div class="character-image">
          <img src="img/character02.png" alt="フラっティ" class="item js-fadeup-1">
        </div>
        <p class="character-name">Flatty（フラッティ）</p>
        <p class="character-copy">元気いっぱいでおしゃべり好きなうさ<br>
          ぎの子。どんなときも明るく、<br>
          楽しい空気を作ってくれるよ♪</p>
      </article>

      <article class="character-card">
        <div class="character-image">
          <img src="img/character03.png" alt="キャメロン" class="item js-fadeup-1">
        </div>
        <p class="character-name">Cameron（キャメロン）</p>
        <p class="character-copy">おっとりマイペースなかめの子。 <br>
          ゆっくりだけど、いつもみんなを<br>
          よく見ていて、あたたかい気持ちを<br>
          届けてくれる。</p>
      </article>
    </div>
  </section>

  <!-- ================= Map ================= -->
<section class="map" id="map" style="background-color: #fff;">
  <div class="Title-Box">
    <h2 class="section-title1 js-fadeup">MAP</h2>
    <p class="subtitle js-fadeup">
      <span class="pick" style="color: var(--accent-2);">プ</span>ロトピアの世界
    </p>
  </div>

  <div class="map-wrapper">

    <!-- 鳥：左下 -->
    <img src="img/bird.png" alt="鳥" class="map-object bird bird-left">

    <!-- 鳥：右上 -->
    <img src="img/bird.png" alt="鳥" class="map-object bird bird-right">


    <!-- アイコン1 -->
    <div class="map-icon icon-1">
      ?
      <div class="map-tooltip">
        森のエリアです。<br>
        キャメロンたちが<br>
        よく集まる場所。
      </div>
    </div>

    <!-- アイコン2 -->
    <div class="map-icon icon-2">
      ?
      <div class="map-tooltip">
        湖のエリア。<br>
        フラッティの<br>
        お気に入りスポット。
      </div>
    </div>

    <!-- アイコン3 -->
    <div class="map-icon icon-3">
      ?
      <div class="map-tooltip">
        丘のエリア。<br>
        エリオットが<br>
        のんびり過ごします。
      </div>
    </div>

  </div>

  <!-- 背景テキストスライダー -->
    <div class="map-bgText">
      <div class="map-bgText-track">
        <span style="color: #cc599761;">PROTOPIA WORLD</span>
        <span style="color: #57b1cf80;">PROTOPIA WORLD</span>
        <span style="color: #f4ea285c;">PROTOPIA WORLD</span>
        <span style="color: #cc55557a;">PROTOPIA WORLD</span>
      </div>
    </div>

<div class="map-characters">

  <!-- キャラ1 -->
  <div class="map-character char-elliot">
    <img src="img/Elliot-Anime.gif" alt="エリオット">
  </div>

  <!-- キャラ2 -->
  <div class="map-character char-flatty">
    <img src="img/Flatty-Anime.gif" alt="フラッティ">
  </div>

  <!-- キャラ3 -->
  <div class="map-character char-cameron">
    <img src="img/Cameron-Anime.gif" alt="キャメロン">
  </div>

</div>

    <!--  
      <p class="map-text">
        マップ内の「？」をタップすると、エリアの説明が表示されます。
      </p>
    -->
</section>


  <!-- ================= LINE Stamp ================= -->
  <section class="stamp" id="stamp" style="background-color:var(--color-main)">
  <div class="Title-Box">
    <h2 class="section-title1 js-fadeup"><img src="img/line.png" alt="LINE" class="lineimage"></h2>
    <p class="subtitle js-fadeup">
      <span class="pick" style="color: var(--accent-2);">ス</span>タンプ
    </p>
  </div>
  <div class="line-slider">
    <!-- 上段 -->
    <div class="slider-row row-top">
      <div class="slider-track">
        <!-- 7個 × 2（ループ用に複製） -->
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>

        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
      </div>
    </div>

    <!-- 下段 -->
    <div class="slider-row row-bottom">
      <div class="slider-track reverse">
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>

        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
        <div class="box" style="background-color: var(--accent-1);"></div>
        <div class="box" style="background-color: var(--color-sub);"></div>
      </div>
    </div>
  </div>

<div class="stampText">
  <h3 class="text">
    毎日がちょっと楽しくなる！<br>
    プロトピアのキャラクタースタンプ、できました。
  </h3>
    <p class="stamp-text">
    ゆるくてかわいいキャラクターたちが、<br>
    日常のやりとりに“ほっこり”と“ありがとう”を届けます。<br>
    お仕事にも、プライベートにも、ふと笑顔になれるひとことを。
    </p>
</div>

<div class="buttonBox">
  <a href="" style="text-decoration: none;">
    <div class="button">
      <p class="btnText">ダウンロードはこちら</p>
    </div>
  </a>
</div>
  </section>

  <!-- ================= Goods ================= -->
  <!-- ▼ECグッズショップ：一時非表示（再開時は style の display:none を外す） -->
  <section class="goods" id="goods" style="background-color: #fffdee; display: none;">
  <div class="inner">
    <div class="Title-Box">
      <h2 class="section-title1 js-fadeup">Goods</h2>
        <p class="subtitle js-fadeup"><span class="pick" style="color: var(--accent-2);">グ</span>ッズショップ</p>
    </div>
    <p class="sectionLead">
      キャラクターグッズはこちらからチェック！<br>
      お気に入りの子を見つけて、毎日にかわいいをプラスしよう
    </p>

    <div class="goodsList">
      <article class="goodsItem">
        <div class="goodsImg"></div>
        <button class="buyBtn">BUY</button>
        <h3 class="goodsName">商品やグッズの名前</h3>
        <p class="goodsPrice">¥1,000 + tax</p>
        <p class="goodsText">
          商品やグッズの紹介文章や使用用途などを記載して、
          ひと目で分かる説明を入れる。
        </p>
      </article>

      <!-- 同じ構造を繰り返す -->
      <article class="goodsItem">
        <div class="goodsImg"></div>
        <button class="buyBtn">BUY</button>
        <h3 class="goodsName">商品やグッズの名前</h3>
        <p class="goodsPrice">¥1,000 + tax</p>
        <p class="goodsText">
          商品やグッズの紹介文章や使用用途などを記載して、
          ひと目で分かる説明を入れる。
        </p>
      </article>
      <article class="goodsItem">
        <div class="goodsImg"></div>
        <button class="buyBtn">BUY</button>
        <h3 class="goodsName">商品やグッズの名前</h3>
        <p class="goodsPrice">¥1,000 + tax</p>
        <p class="goodsText">
          商品やグッズの紹介文章や使用用途などを記載して、
          ひと目で分かる説明を入れる。
        </p>
      </article>
      <article class="goodsItem">
        <div class="goodsImg"></div>
        <button class="buyBtn">BUY</button>
        <h3 class="goodsName">商品やグッズの名前</h3>
        <p class="goodsPrice">¥1,000 + tax</p>
        <p class="goodsText">
          商品やグッズの紹介文章や使用用途などを記載して、
          ひと目で分かる説明を入れる。
        </p>
      </article>
      <article class="goodsItem">
        <div class="goodsImg"></div>
        <button class="buyBtn">BUY</button>
        <h3 class="goodsName">商品やグッズの名前</h3>
        <p class="goodsPrice">¥1,000 + tax</p>
        <p class="goodsText">
          商品やグッズの紹介文章や使用用途などを記載して、
          ひと目で分かる説明を入れる。
        </p>
      </article>
      <article class="goodsItem">
        <div class="goodsImg"></div>
        <button class="buyBtn">BUY</button>
        <h3 class="goodsName">商品やグッズの名前</h3>
        <p class="goodsPrice">¥1,000 + tax</p>
        <p class="goodsText">
          商品やグッズの紹介文章や使用用途などを記載して、
          ひと目で分かる説明を入れる。
        </p>
      </article>
    </div>

    <div class="buttonBox">
      <a href="" style="text-decoration: none;">
        <div class="button">
          <p class="btnText">オンラインショップ</p>
        </div>
      </a>
    </div>

  </div>
</section>


  <!-- ================= Nwes ================= -->
<section class="news" id="news" style="background-color:var(--color-main)">
  <div class="inner-news">
    <div class="Title-Box">
      <h2 class="section-title1 js-fadeup">News</h2>
        <p class="subtitle js-fadeup"><span class="pick" style="color: var(--accent-2);">新</span>着情報</p>
    </div>

    <div class="newsList">

      <!-- 繰り返し -->
      <article class="newsItem">
        <div class="newsImg"></div>
        <time class="newsDate">2026.02.14</time>
        <h3 class="newsItemTitle">新ページ公開しました！</h3>

        <div class="newsTags">
          <span class="tag">新着情報</span>
          <span class="tag">告知情報</span>
          <span class="tag">リリース</span>
        </div>

        <p class="newsText">
          イベントに対する説明文や内容を記載していきます。
        </p>
      </article>
       <!--  
      <article class="newsItem"><div class="newsImg"></div>
        <time class="newsDate">2025.04.01</time>
        <h3 class="newsItemTitle">イベントタイトル！</h3>

        <div class="newsTags">
          <span class="tag">イベント</span>
          <span class="tag">告知情報</span>
          <span class="tag">リリース</span>
        </div>

        <p class="newsText">
          イベントに対する説明文や内容を記載していきます。
        </p></article>
      <article class="newsItem"><div class="newsImg"></div>
        <time class="newsDate">2025.04.01</time>
        <h3 class="newsItemTitle">イベントタイトル！</h3>

        <div class="newsTags">
          <span class="tag">イベント</span>
          <span class="tag">告知情報</span>
          <span class="tag">リリース</span>
        </div>

        <p class="newsText">
          イベントに対する説明文や内容を記載していきます。
        </p></article>
      <article class="newsItem">
        <div class="newsImg"></div>
        <time class="newsDate">2025.04.01</time>
        <h3 class="newsItemTitle">イベントタイトル！</h3>

        <div class="newsTags">
          <span class="tag">イベント</span>
          <span class="tag">告知情報</span>
          <span class="tag">リリース</span>
        </div>

        <p class="newsText">
          イベントに対する説明文や内容を記載していきます。
        </p>
      </article>
      <article class="newsItem">
        <div class="newsImg"></div>
        <time class="newsDate">2025.04.01</time>
        <h3 class="newsItemTitle">イベントタイトル！</h3>

        <div class="newsTags">
          <span class="tag">イベント</span>
          <span class="tag">告知情報</span>
          <span class="tag">リリース</span>
        </div>

        <p class="newsText">
          イベントに対する説明文や内容を記載していきます。
        </p>
      </article>
      -->
    </div>
  </div>
</section>



  <!-- ================= Contact ================= -->
  <section class="contact" id="contact" style="background-color: #F2FFF6;">
    <h2 class="section-title1 js-fadeup">プロトピアへお問い合わせ</h2>
    <p class="subtitle js-fadeup"><span class="pick" style="color: var(--accent-2);">お</span>問い合わせフォーム</p>
    <p class="concept-text">
      イベント出演やコラボのご依頼はこちらから<br>
      お誘いをお待ちしてます
    </p>

    <form method="post" id="contactForm" class="contact-box">

      <div class="form-group">
        <label class="label">お問い合わせ内容</label>
        <label><input type="radio" name="type" value="コラボ" checked> コラボのお誘い</label>
        <label><input type="radio" name="type" value="イベント"> イベントのお誘い</label>
        <label><input type="radio" name="type" value="その他"> その他</label>
      </div>

      <div class="form-group">
        <label class="label">お名前<span>必須</span></label>
        <input type="text" name="name" required>
      </div>

      <div class="form-group">
        <label class="label">おなまえ（フリガナ）<span>必須</span></label>
        <input type="text" name="kana" required>
      </div>

      <div class="form-group">
        <label class="label">メールアドレス<span>必須</span></label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label class="label">電話番号<span>必須</span></label>
        <input type="tel" name="tel" required>
      </div>

      <div class="form-group">
        <label class="label">お問い合わせ内容<span>必須</span></label>
        <textarea name="message" rows="6" required></textarea>
      </div>

      <div class="form-group">
        <label class="label">プライバシーポリシー</label>
        <div class="policy-box">
          個人情報はお問い合わせ対応以外の目的では使用しません。
        </div>
        <label class="check">
          <input type="checkbox" name="agree" required>
          プライバシーポリシーに同意します
        </label>
      </div>

      <button type="submit" class="submit-btn">手紙を送る</button>
    </form>
    
    <!-- モーダル -->
    <div id="popupModal" class="popup-modal">
      <div class="popup-content">
        <span class="popup-close">&times;</span>
        <p class="popup-message">お問い合わせありがとうございました。</p>
      </div>
    </div>


  </section>

  <!-- ================= Footer ================= -->
  <footer class="footer">

     <!-- キャラクター -->
  <div class="footer-characters">
    <div class="footer-chara rotate slow">
      <img src="img/Cameron_B.png" alt="キャラ1">
    </div>
    <div class="footer-chara rotate medium">
      <img src="img/Flatty_B.png" alt="キャラ2">
    </div>
    <div class="footer-chara rotate slow">
      <img src="img/Elliot_B.png" alt="キャラ3">
    </div>
  </div>

  <!-- FOLLOW -->
  <p class="footer-follow">FOLLOW US</p>

  <!-- SNS -->
  <ul class="footer-sns">
    <!-- <li><a href="#"><img src="img/x.png" alt="X"></a></li> -->
    <li><a href="#"><img src="img/Instagram.png" alt="Instagram"></a></li>
    <!-- <li><a href="#"><img src="img/YouTube.png" alt="YouTube"></a></li> -->
    <!--  
    <li><a href="#"><img src="img/icon-threads.svg" alt="Threads"></a></li>
    <li><a href="#"><img src="img/icon-tiktok.svg" alt="TikTok"></a></li>
    -->
  </ul>

    <p style="font-size: 10px;">© Future Land Protopia</p>
  </footer>


  <script src="js/script.js"></script>
</body>
</html>
