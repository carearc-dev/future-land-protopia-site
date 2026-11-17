// ひみつの工房（workshop.php）用のスクリプト
// トップページ用の js/script.js は、このページにない要素（FV動画・お問い合わせフォーム）を前提にしているため読み込まない

document.addEventListener("DOMContentLoaded", () => {
  // ===== ヘッダー（スマホのメニュー開閉・スクロール時の半透明） =====
  const header = document.querySelector(".header");
  const hamburger = document.querySelector(".hamburger");
  const spClose = document.querySelector(".spClose");

  if (header && hamburger && spClose) {
    hamburger.addEventListener("click", () => header.classList.toggle("is-open"));
    spClose.addEventListener("click", () => header.classList.remove("is-open"));
    document.querySelectorAll(".spNav a").forEach(link => {
      link.addEventListener("click", () => header.classList.remove("is-open"));
    });
    window.addEventListener("scroll", () => {
      header.classList.toggle("is-scroll", window.scrollY > 10);
    });
  }

  // ===== カテゴリの絞り込み =====
  // タブの data-filter と、カードの data-category が同じものだけを表示する（all はすべて表示）
  const tabs = document.querySelectorAll(".ws-tab");
  const cards = document.querySelectorAll(".ws-card");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      const filter = tab.dataset.filter;

      tabs.forEach(t => {
        const current = t === tab;
        t.classList.toggle("is-current", current);
        t.setAttribute("aria-pressed", current ? "true" : "false");
      });

      cards.forEach(card => {
        card.hidden = filter !== "all" && card.dataset.category !== filter;
      });
    });
  });
});
