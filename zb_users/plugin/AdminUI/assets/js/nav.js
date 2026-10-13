document.addEventListener('DOMContentLoaded', function() {
  if (window.innerWidth < 992) {
    const body = document.querySelector('body');
    const header = document.querySelector('.header');
    const aside = document.querySelector('.left');
    const menuElement = document.querySelector('.menu');
    const userElement = document.querySelector('.user');
    // 创建并附加overlay到body
    const overlay = document.createElement('div');
    overlay.classList.add('overlay');
    body.appendChild(overlay);
    // 动态创建icon按钮
    const createIconButton = function(className, iconName, parent) {
      const iconDiv = document.createElement('div');
      iconDiv.classList.add(className);
      iconDiv.innerHTML = `<i class="${iconName}"></i>`;
      parent.appendChild(iconDiv);
      return iconDiv;
    };
    // user修饰图标
    const createDecorationSpan = function() {
      const span = document.createElement('span');
      span.classList.add('decoration');
      span.innerHTML = `<i class="icon-person-circle"></i>`;
      return span;
    };
    const toggleClassAction = function(element, className, removeFn, addFn) {
      if (element.classList.contains(className)) {
        removeFn();
      } else {
        addFn();
      }
    };
    // 打开侧边栏菜单的函数
    const openSidebarMenu = function() {
      body.classList.add('menu-open');
      aside.classList.add('active');
      overlay.classList.add('active');
    };
    // 关闭侧边栏菜单的函数
    const closeSidebarMenu = function() {
      body.classList.remove('menu-open');
      aside.classList.remove('active');
      overlay.classList.remove('active');
    };
    // 打开顶部菜单的函数
    const openTopMenu = function() {
      menuElement.style.display = 'block';
      userElement.style.display = 'block';
      body.classList.add('quick-menu-open');
      overlay.classList.add('active');
      // 创建带有图标的修饰span
      const decorationSpan = createDecorationSpan();
      userElement.appendChild(decorationSpan);
    };
    // 关闭顶部菜单的函数
    const closeTopMenu = function() {
      menuElement.style.display = 'none';
      userElement.style.display = 'none';
      body.classList.remove('quick-menu-open');
      overlay.classList.remove('active');
      
      // 移除带有图标的修饰span
      const decorationSpan = userElement.querySelector('.decoration');
      decorationSpan && userElement.removeChild(decorationSpan);
    };
    const toggleSidebarMenu = function() {
      if (body.classList.contains('quick-menu-open')) {
        closeTopMenu();
        openSidebarMenu();
      } else {
        toggleClassAction(body, 'menu-open', closeSidebarMenu, openSidebarMenu);
      }
    };
    const toggleTopMenu = function() {
      if (body.classList.contains('menu-open')) {
        closeSidebarMenu();
        openTopMenu();
      } else {
        toggleClassAction(body, 'quick-menu-open', closeTopMenu, openTopMenu);
      }
    };
    // 当点击遮罩层时关闭所有菜单
    const closeAllMenus = function() {
      closeSidebarMenu();
      closeTopMenu();
    };
    // 动态创建menu-icon和quick-menu-icon按钮
    const menuIcon = createIconButton('menu-icon', 'icon-grid', header);
    const quickMenuIcon = createIconButton('quick-menu-icon', 'icon-gear', header);

    menuIcon.addEventListener('click', toggleSidebarMenu);
    quickMenuIcon.addEventListener('click', toggleTopMenu);
    overlay.addEventListener('click', closeAllMenus);
  }
});
