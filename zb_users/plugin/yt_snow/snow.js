/**
 * snow - 高级雪花效果插件
 * 作者: 唐朝
 * 版本: 1.0.0
 */
(function () {
  "use strict";

  // 默认配置
  const defaults = {
    enable: true,
    count: 100, // 雪花数量
    speed_min: 1, // 最小下落速度
    speed_max: 3, // 最大下落速度
    size_min: 2, // 最小尺寸
    size_max: 5, // 最大尺寸
    color: "#ffffff", // 雪花颜色
    opacity_min: 0.3, // 最小透明度
    opacity_max: 0.8, // 最大透明度
    wind: 0, // 水平风力 (-5 到 5)
    sway: true, // 启用摇摆效果
    interaction: true, // 启用鼠标交互
    z_index: 999999, // Z轴索引
  };

  // 合并用户配置与默认配置
  const config = Object.assign({}, defaults, window.ytConfig || {});

  if (!config.enable) return;

  let canvas, ctx;
  let width, height;
  let particles = [];
  let mouse = { x: -100, y: -100, active: false };

  // 初始化
  function init() {
    // 创建画布
    canvas = document.createElement("canvas");
    canvas.id = "yt-snow-canvas";
    canvas.style.position = "fixed";
    canvas.style.top = "0";
    canvas.style.left = "0";
    canvas.style.width = "100%";
    canvas.style.height = "100%";
    canvas.style.pointerEvents = "none"; // 允许点击穿透
    canvas.style.zIndex = config.z_index;
    document.body.appendChild(canvas);

    ctx = canvas.getContext("2d");

    // 窗口大小调整处理
    window.addEventListener("resize", onResize);
    onResize(); // 初始尺寸设置

    // 鼠标交互
    if (config.interaction) {
      document.addEventListener("mousemove", onMouseMove);
      document.addEventListener("touchstart", onTouchMove, { passive: true });
      document.addEventListener("touchmove", onTouchMove, { passive: true });
    }

    // 创建粒子
    createParticles();

    // 开始循环
    loop();
  }

  function createParticles() {
    particles = [];
    for (let i = 0; i < config.count; i++) {
      particles.push(new Particle());
    }
  }

  function onResize() {
    width = window.innerWidth;
    height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;
  }

  function onMouseMove(e) {
    mouse.x = e.clientX;
    mouse.y = e.clientY;
    mouse.active = true;
  }

  function onTouchMove(e) {
    if (e.touches.length > 0) {
      mouse.x = e.touches[0].clientX;
      mouse.y = e.touches[0].clientY;
      mouse.active = true;
    }
  }

  class Particle {
    constructor() {
      this.reset(true);
    }

    reset(initial = false) {
      this.x = Math.random() * width;
      this.y = initial ? Math.random() * height : -10;
      this.size =
        Math.random() * (config.size_max - config.size_min) + config.size_min;
      this.speed =
        Math.random() * (config.speed_max - config.speed_min) +
        config.speed_min;
      this.opacity =
        Math.random() * (config.opacity_max - config.opacity_min) +
        config.opacity_min;

      // 摇摆属性
      this.swaySpeed = Math.random() * 0.05 + 0.01;
      this.swayAngle = Math.random() * Math.PI * 2;
      this.swayAmp = Math.random() * 1 + 0.5;

      // 速度
      this.vx = (Math.random() - 0.5) * 0.5 + config.wind;
      this.vy = this.speed;
    }

    update() {
      // 应用重力/速度
      this.y += this.vy;

      // 应用摇摆效果
      if (config.sway) {
        this.swayAngle += this.swaySpeed;
        this.x += Math.sin(this.swayAngle) * this.swayAmp;
      }

      // 应用风力
      this.x += this.vx;

      // 鼠标交互（排斥效果）
      if (config.interaction && mouse.active) {
        const dx = this.x - mouse.x;
        const dy = this.y - mouse.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        const minDist = 150; // 交互半径

        if (dist < minDist) {
          const force = (minDist - dist) / minDist; // 0 到 1
          const angle = Math.atan2(dy, dx);
          const push = force * 5;

          this.x += Math.cos(angle) * push;
          this.y += Math.sin(angle) * push;
        }
      }

      // 边界检查
      if (this.y > height + 10 || this.x < -50 || this.x > width + 50) {
        this.reset();
      }
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fillStyle = config.color;
      ctx.globalAlpha = this.opacity;
      ctx.fill();
    }
  }

  function loop() {
    ctx.clearRect(0, 0, width, height);

    particles.forEach((p) => {
      p.update();
      p.draw();
    });

    requestAnimationFrame(loop);
  }

  // 在DOM加载完成时自动初始化，或如果已经加载则立即初始化
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();