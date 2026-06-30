<?php
// ================= 初期設定 =================
$errors = [];
$success = false;
$mailConfigPath = __DIR__ . "/config.php";
$mailConfig = is_file($mailConfigPath) ? require $mailConfigPath : [];
$contactTo = $mailConfig["contact_to"] ?? "mail@daikanyama-hb.com,m.kamei@daikanyama-hb.com";
$contactFrom = $mailConfig["contact_from"] ?? "mail@daikanyama-hb.com";
$contactFromName = $mailConfig["contact_from_name"] ?? "Future Land Project";

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

    $to = $contactTo;
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

    $encodedFromName = mb_encode_mimeheader($contactFromName, "UTF-8");
    $headers = [
      "From: {$encodedFromName} <{$contactFrom}>",
      "Reply-To: {$email}",
    ];

    if (mb_send_mail($to, $subject, $body, implode("\r\n", $headers))) {
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
    <h2 class="section-title js-fadeup"><span class="line">FUTURE LAND PROTOPIAって？</span></h2>

    <div class="concept-visual">
      <img src="img/concept-img.png" alt="" class="concept-img">
    </div>

    <p class="PC concept-text js-fadeup">
      ここでは、私たちのブランドやキャラクターについてご紹介します。世界観や想いがしっかり伝わるように、<br>
      ちょっとだけ熱く語らせてください！このセクションでは、単なる説明ではなく、<br>
      「なんか好きかも」「気になるかも」と感じてもらえるように、感情に届く表現を意識しています。<br>
      読みながら、少しでもワクワクしてもらえたら嬉しいです。
    </p>

    <p class="SP concept-text js-fadeup">
      ここでは、私たちのブランドやキャラクター<br>についてご紹介します。世界観や想いがしっかり<br>伝わるように、
      ちょっとだけ熱く語らせてください！このセクションでは、単なる説明ではなく、<br>
      「なんか好きかも」「気になるかも」と<br>感じてもらえるように、感情に届く表現を<br>意識しています。
      読みながら、少しでも<br>ワクワクしてもらえたら嬉しいです。
    </p>
  </section>

  <!-- ================= Characters ================= -->
  <section class="characters" id="characters" style="background-color: #fffdee;">
    <div class="Title-Box">
      <h2 class="section-title1 js-fadeup">FRIENDS</h2>
        <p class="subtitle js-fadeup"><span class="pick" style="color: var(--accent-2);">な</span>かまたち</p>
    </div>

    <div class="character-list">

      <article class="character-card">
        <div class="character-image">
          <img src="img/character02.png" alt="フラっティ" class="item js-fadeup-1">
        </div>
        <p class="character-name">Flatty（フラッティ）</p>
        <p class="character-copy">フラッティはせっかちなところが<br>
          あるけど正義感の強い子</p>
      </article>

      <article class="character-card">
        <div class="character-image">
          <img src="img/character01.png" alt="エリオット" class="item js-fadeup-1">
        </div>
        <p class="character-name">Elliot（エリオット）</p>
        <p class="character-copy">エリオットは普段はおっとり<br>
          穏やかな男の子</p>
      </article>

      <article class="character-card">
        <div class="character-image">
          <img src="img/character03.png" alt="キャメロン" class="item js-fadeup-1">
        </div>
        <p class="character-name">Cameron（キャメロン）</p>
        <p class="character-copy character-copy-cameron">
          <span class="cam-line cam-line-1">キャメロンはちょっとおてんばですが、</span><br>
          <span class="cam-line cam-line-2">ファッション楽しいことを</span><br>
          <span class="cam-line cam-line-3">するのが好きな女の子</span>
        </p>
      </article>

    <p class="PC concept-text">
      プロトピアの森に暮らす3人のおともだち。それぞれが「ありがとう」の気持ちを大切にしながら、<br>
      毎日ちいさな幸せを見つけています。お花のようにカラフルでやさしい心をもった彼らが、<br>
      あなたの毎日にそっと彩りを届けてくれるかもしれません。
    </p>

    <p class="SP concept-text">
      プロトピアの森に暮らす3人のおともだち。<br>それぞれが「ありがとう」の気持ちを<br>大切にしながら、
      毎日ちいさな幸せを<br>見つけています。お花のようにカラフルで<br>やさしい心をもった彼らが、
      あなたの毎日に<br>そっと彩りを届けてくれるかもしれません。
    </p>

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
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>

        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
      </div>
    </div>

    <!-- 下段 -->
    <div class="slider-row row-bottom">
      <div class="slider-track reverse">
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>

        <div class="box" style="background-color: var(--color-sub);">
        <p style="font-size: 25px; color: var(--color-font);line-height: 225px; ">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--accent-1);">
          <p style="font-size: 25px; color: var(--color-main); line-height: 225px;">coming soon</p>
        </div>
        <div class="box" style="background-color: var(--color-sub);">
          <p style="font-size: 25px; color: var(--color-font); line-height: 225px;">coming soon</p>
        </div>
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

  <!-- ================= Goods ================= 
  ▼ECグッズショップ：一時非表示（再開時は style の display:none を外す）
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

       同じ構造を繰り返す 
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
-->

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



  <!-- ================= Message ================= -->
  <section class="message" id="message">
    <div class="message-inner js-fadeup">
      <p class="message-label">Our Message</p>

      <h2 class="message-title">
        <span>"<span class="message-title-accent">地球</span>にやさしい"</span>
        <span>"<span class="message-title-accent">人</span>にやさしい"</span>
      </h2>

      <p class="message-lead">
        人間も動物も共存する美しい地球。<br>
        たったひとつしかない青く輝く地球。
      </p>

      <p class="message-text">
        地球の良い未来につなげていくために、<br class="PC">
        <br class="SP">
        私たちひとりひとりが<br class="SP">身近な視点から<br>
        見つめ直し行動することがとても大切だね。
      </p>

      <p class="message-from">フラッティと良き仲間より</p>
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
          <p>株式会社CAREARC（以下「弊社」といいます。）は、お客様の個人情報の保護について非常に重要なものと認識し、個人情報の保護に関する法律（以下「個人情報保護法」といいます。）の定める個人情報を、以下のプライバシーポリシー（以下「本ポリシー」といいます。）に従って、適切に取得し、適切な取り扱い及び保護に努めるものといたします。</p>

          <h3>個人情報の取得</h3>
          <p>弊社は、弊社が運営提供するサービス（以下「弊社サービス」といいます。）を通して、お客様の個人情報（個人情報保護法第２条第１項に定義される個人情報を意味します。以下同じ。）を適正な手段により取得いたします。なお、お客様は、本ポリシーに従った個人情報の取得及び取扱いに同意できない場合、弊社サービスを利用することはできません。弊社サービスを利用したお客様は、本ポリシーに同意したものとみなします。</p>

          <h3>個人情報の利用目的について</h3>
          <p>（１）弊社が、取得・収集・利用するお客様の個人情報には、以下の情報が含まれます。</p>
          <ol>
            <li>事業者名、代表者名、担当者名、役職、住所、店舗の名称・所在地、電話番号、メールアドレス、売上高や自己資本、決算年月日などの財務状況に係る情報、申請する事業計画と内容、事業費⽤、振込⼝座、助成金申請に必要な労務情報、その他特定の個人を識別することができる情報</li>
            <li>弊社サービスの利用に用いられる携帯電話端末等の固有情報（端末固有のID等の個体識別情報等を含む）</li>
            <li>弊社サービスの利用時に自動で生成・保存されるIPアドレス、お客様からのリクエスト日時、操作履歴情報</li>
            <li>携帯電話端末等から送信される位置情報</li>
            <li>決済処理に関する取引情報（弊社との契約情報、取扱商品情報、注文履歴情報、取引履歴情報、決済に関する履歴情報、提携決済事業者に提供された請求情報・支払情報等を含むが、これに限られない）</li>
            <li>個人情報と一体となった個人の属性に関する情報</li>
          </ol>
          <p>（２）弊社は、お客様の個人情報を、以下の目的で利用致します</p>
          <ol>
            <li>弊社サービスの運営</li>
            <li>弊社サービスに関するご案内やご連絡</li>
            <li>弊社サービスに関するお問い合わせ等への対応</li>
            <li>弊社サービスに関する弊社の定めた規約、ガイドライン等に違反する行為への対応</li>
            <li>弊社サービスの改善や解析、または新サービスの開発等</li>
            <li>弊社サービスや関連会社の商品・サービスに関するお客様への通知</li>
            <li>弊社サービスに関連する外部サービスへの申請等</li>
            <li>弊社サービスに関連するキャンペーン等の賞品発送</li>
            <li>提携サービスの提供又は提携サービスと連携による弊社サービスの提供、お客様のニーズや興味・関心に適合する広告情報等の表示、広告効果の分析</li>
            <li>お客様のご本人確認</li>
            <li>統計データの作成及び当該データの第三者への提供</li>
            <li>広告効果測定のために第三者の運営ツールより個人関連情報を取得し、お申込情報との照合</li>
            <li>上記目的に付随する利用</li>
            <li>その他、常識の範囲内で弊社が必要と判断した目的の遂行</li>
          </ol>

          <h3>個人情報の開示に関する免責</h3>
          <p>弊社は、本ポリシーに掲げる場合及び個人情報保護法その他の法令により認められる場合を除き、お客様の同意を得ることなく個人情報を第三者に開示することはありません。但し、次の各号に該当する場合はこの限りではありません。</p>
          <ol>
            <li>個人情報法保護法、およびその他法令の定める範囲内で利用する場合。</li>
            <li>国や地方自治体の機関、もしくはそれらから委託を受けた者の要請により開示が必要であると判断した場合で、本人の同意を得ることにより当該事務の遂行に支障を及ぼすおそれがある場合。</li>
            <li>人の生命、身体や財産の保護のため、お客様の同意を得ることが困難な状況の場合。</li>
          </ol>

          <h3>個人情報の管理について</h3>
          <p>弊社は、個人情報へのアクセスの管理、個人情報の持出し手段の制限、外部からの不正なアクセスの防止のための措置その他の個人情報の漏えい、滅失またはき損の防止その他の個人情報の安全管理のために、必要かつ適切な措置を講じます。</p>

          <h3>個人情報の開示、訂正、利用停止等の申請への応対</h3>
          <p>お客様より、個人情報の利用目的の通知、開示、訂正・追加・削除・利用停止等の申請があった場合、ご本人確認をした上で、当該お客様に対し個人情報保護法の定めに従い、応対いたします。但し、個人情報保護法その他の法令により弊社が開示の義務を負わない場合は、この限りではありません。なお、当該申請に際し発生した通信費、交通費、及びご本人確認の際にご用意いただく資料等に関する費用につきましては、全てお客様のご負担とさせていただきます。</p>

          <h3>個人情報の第三者提供について</h3>
          <p>弊社は、法令に定める場合を除き、個人情報を、事前に本人の同意を得ることなく第三者に提供しません。個人情報の開示・訂正・利用停止・削除について 当法人はご提供いただきました個人情報について、ご本人より自己情報の開示・訂正・利用停止・削除等のご依頼があった場合は、ご本人を確認した上で合理的な範囲で速やかに対応させていただきます。</p>

          <h3>問い合わせ窓口について</h3>
          <p>弊社の個人情報の取り扱いにつきまして、ご意見、ご質問、ご要望等がございましたら、下記までご連絡下さるようお願いいたします。</p>
          <p>株式会社CAREARC</p>
          <p>〒150-0021 東京都渋谷区恵比寿西2-21-1 ジョワレ代官山4F</p>
          <p>Mail：info@carearc.co.jp</p>
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
    <li><a href="https://www.instagram.com/future_land_protopia"><img src="img/Instagram.png" alt="Instagram"></a></li>
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
