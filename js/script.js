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

// 速度を動的に変えたい場合
  const tracks = document.querySelectorAll('.slider-track');
  tracks.forEach(track => {
    track.style.animationDuration = '50s';
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
