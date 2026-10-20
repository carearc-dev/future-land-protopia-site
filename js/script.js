document.addEventListener("DOMContentLoaded", () => {
  const icons = document.querySelectorAll(".map-icon");

  if (!icons.length) return;

  icons.forEach(icon => {
    icon.addEventListener("click", (e) => {
      e.stopPropagation();

      // 他の吹き出しを閉じる
      icons.forEach(i => {
        if (i !== icon) i.classList.remove("active");
      });

      // 自分をトグル
      icon.classList.toggle("active");
    });
  });

  // 画面のどこかをタップしたら閉じる
  document.addEventListener("click", () => {
    icons.forEach(icon => icon.classList.remove("active"));
  });
});

// ===== Activity スライダー（右→左に流れる） =====
// HTMLには各段の枠を1回だけ並べる。ここで
//  ① 大きい画面でも流れの途中で右端が空かないよう、並びをくり返して幅を足す
//  ② 同じ並びをもう1組つなげ、半分（＝1組分）流したら先頭に戻すことで切れ目なくループさせる
// 速さは1枠あたり約7秒（以前の速さ）。枠の数から再生時間を決めるので、画像を増やしても速さは変わらない
// 並べ終わるまでは CSS で止めておき（.is-ready が付いたら流す）、途中で途切れた状態を見せない
  const SECONDS_PER_TILE = 7;
  // 開いたときの画面幅に関係なく、大きいモニター（2560px）でも途切れない分まで並べる
  const MIN_COVER_WIDTH = 2560;

  const copyTile = (tile) => {
    const copy = tile.cloneNode(true);
    copy.setAttribute('aria-hidden', 'true');
    copy.querySelectorAll('img').forEach(img => { img.alt = ''; });
    return copy;
  };

  const buildSlider = ({ track, group, original }) => {
    track.querySelectorAll('.slider-group[aria-hidden="true"]').forEach(copy => copy.remove());
    group.replaceChildren(...original);

    const tileWidth = group.scrollWidth / original.length;
    // 下段は半枠ずらしているので、画面幅＋2枠分の余裕を持たせる
    const needWidth = Math.max(window.innerWidth, window.screen ? window.screen.width : 0, MIN_COVER_WIDTH) + tileWidth * 2;
    for (let i = 0; group.scrollWidth < needWidth && i < 30; i++) {
      original.forEach(tile => group.appendChild(copyTile(tile)));
    }

    const loopCopy = group.cloneNode(false);
    loopCopy.setAttribute('aria-hidden', 'true');
    [...group.children].forEach(tile => loopCopy.appendChild(copyTile(tile)));
    track.appendChild(loopCopy);

    track.style.animationDuration = `${group.children.length * SECONDS_PER_TILE}s`;
    track.classList.add('is-ready');
  };

  const sliders = [...document.querySelectorAll('.slider-track')]
    .map(track => {
      const group = track.querySelector('.slider-group');
      return group && group.children.length ? { track, group, original: [...group.children] } : null;
    })
    .filter(Boolean);

  sliders.forEach(buildSlider);

  // ウィンドウを広げる・別のモニターへ移す・縮小表示にするなどで並びが足りなくなったら作り直す
  let sliderResizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(sliderResizeTimer);
    sliderResizeTimer = setTimeout(() => {
      sliders.forEach(slider => {
        const { group } = slider;
        const tileWidth = group.scrollWidth / group.children.length;
        if (group.scrollWidth < window.innerWidth + tileWidth * 2) buildSlider(slider);
      });
    }, 200);
  });

  
const header = document.querySelector('.header');
const hamburger = document.querySelector('.hamburger');
const spClose = document.querySelector('.spClose');
const spLinks = document.querySelectorAll('.spNav a');

// 開く
hamburger.addEventListener('click', () => {
  header.classList.toggle('is-open');
});

// 閉じる（×）
spClose.addEventListener('click', () => {
  header.classList.remove('is-open');
});

// メニュークリックで閉じる
spLinks.forEach(link => {
  link.addEventListener('click', () => {
    header.classList.remove('is-open');
  });
});

// スクロール判定
window.addEventListener('scroll', () => {
  if (window.scrollY > 10) {
    header.classList.add('is-scroll');
  } else {
    header.classList.remove('is-scroll');
  }
});

const fadeItems = document.querySelectorAll('.js-fadeup');

const fadeObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-show');
        fadeObserver.unobserve(entry.target);
      }
    });
  },
  {
    rootMargin: '-30px',
    threshold: 0.1
  }
);

fadeItems.forEach(item => {
  fadeObserver.observe(item);
});

// ===== キャラクター ぽよん出現アニメーション =====
const poyonItems = document.querySelectorAll('.js-fadeup-1');

const poyonObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-show-1');
        poyonObserver.unobserve(entry.target);
      }
    });
  },
  {
    rootMargin: '-40px',
    threshold: 0.2
  }
);

poyonItems.forEach(item => {
  poyonObserver.observe(item);
});

// ================= Header show / hide by FV =================
document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.header');
  const fv = document.getElementById('fv');

  if (!header || !fv) return;

  let isShown = false;

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (!entry.isIntersecting && !isShown) {
        // 表示開始（ワンクッション）
        isShown = true;
        header.classList.add('is-active');

        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            header.classList.add('is-visible');
          });
        });

      } else if (entry.isIntersecting && isShown) {
        // 非表示開始
        isShown = false;
        header.classList.remove('is-visible');

        setTimeout(() => {
          header.classList.remove('is-active');
        }, 1200);
      }
    },
    {
      root: null,
      rootMargin: '-70% 0px 0px 0px',
      threshold: 0
    }
  );

  observer.observe(fv);
});

// お問い合わせフォーム完了ポップアップ表示
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const modal = document.getElementById("popupModal");
  const closeBtn = modal.querySelector(".popup-close");
  const messageText = modal.querySelector(".popup-message");

  modal.style.display = "none"; // 初期非表示

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);

    try {
      const res = await fetch("", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" }
      });
      const result = await res.json();

      if (result.success) {
        messageText.textContent = "お問い合わせありがとうございました。";
        modal.style.display = "flex";
        form.reset();
      } else {
        messageText.textContent = result.errors.join("\n");
        modal.style.display = "flex";
      }

    } catch (err) {
      messageText.textContent = "送信中にエラーが発生しました。";
      modal.style.display = "flex";
      console.error(err);
    }
  });

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });
  window.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });
});
