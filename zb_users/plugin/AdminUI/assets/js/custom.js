//必须DOM加载完执行，否则有些动态节点未加载时无法查找到
document.addEventListener('DOMContentLoaded', function() {
  //给tbUpdateInfo模块每个p前面追加一个美化图标
  function beautifyTbUpdateInfo() {
    let pElements = document.querySelectorAll('#tbUpdateInfo p');
    pElements.forEach(pElement => {
      let iconElement = document.createElement('i');
      iconElement.classList.add('icon-check2-circle');
      iconElement.style.paddingRight = '5px';
      pElement.insertBefore(iconElement, pElement.firstChild);
    });
    let zblogNewsRefresh = document.querySelector('#tbUpdateInfo th a');
    zblogNewsRefresh && zblogNewsRefresh.addEventListener('click', () => location.reload());
  }
  //把#thankslist模块移动到#divMain2里面
  function moveThanksList() {
    const divMain2 = document.getElementById('divMain2');
    const thankslistDiv = document.querySelector('#thankslist');
    divMain2 && thankslistDiv && divMain2.appendChild(thankslistDiv);
  }
  //判断首页的#divMain2，只要包含下面3模块之一就添加一个indexPage2类名方便写样式
  function classifyMain2() {
    const divMain2 = document.getElementById('divMain2');
    for (let childElement of divMain2.children) {
      if (['tbStatistic', 'tbUpdateInfo', 'thankslist'].includes(childElement.getAttribute('id'))) {
        divMain2.classList.add('indexPage2');
        break;
      }
    }
  }
  //#divMain添加.indexPage钩子，修改span的内容为“后台首页”
  function labelIndexPage() {
    if (document.querySelector('.indexPage2')) {
      let parentDiv = document.querySelector('.indexPage2').parentNode;
      parentDiv.classList.add('indexPage');
      let spanElement = document.querySelector('.indexPage .divHeader span');
      spanElement && (spanElement.textContent = '后台首页');
    }
  }
  //删除所有主题和插件里的图标（节省空间，也能更区别于系统btn）
  function removeIconsFromThemesAndPlugins() {
    const topmenu = document.getElementById("topmenu");
    const links = topmenu.querySelectorAll("a");
    links.forEach(link => {
      if (link.href.includes("zb_users/theme") || link.href.includes("zb_users/plugin")) {
        let icon = link.parentElement.querySelector("i");
        icon && icon.remove();
      }
    });
  }
  //#topmenu 下面每个li点击的时候都添加.on高亮
  function highlightMenuItem() {
    let menuItems = document.querySelectorAll('#topmenu li');
    // 首先移除所有菜单项的高亮
    menuItems.forEach(item => item.classList.remove('on'));
    // 为每个菜单项添加点击事件
    menuItems.forEach(item => {
      item.addEventListener('click', function() {
        // 点击时，移除所有菜单项的高亮，然后只高亮当前点击的菜单项
        menuItems.forEach(item => item.classList.remove('on'));
        this.classList.add('on');
        localStorage.setItem('activeMenuItem', this.id);
      });
    });
    // 从本地存储中获取上一次点击的菜单项ID
    let activeMenuItemId = localStorage.getItem('activeMenuItem');
    // 如果本地存储中有记录，则只高亮该菜单项
    if (activeMenuItemId) {
      let activeMenuItem = document.getElementById(activeMenuItemId);
      activeMenuItem && activeMenuItem.classList.add('on');
    }
  }
  //user模块追加zblog官网，修改部分图标和文案
  function updateUserModule() {
    let userbtn = document.querySelector('.userbtn');
    let originalProfileLinks = userbtn.querySelectorAll('.profile');
    originalProfileLinks.forEach(link => userbtn.removeChild(link));

    let currentProtocol = window.location.protocol;
    let currentHost = window.location.host;

    let frontEndLink = createLinkElement('font-end', `${currentProtocol}//${currentHost}`, 'icon-house-fill', '网站前台');
    let zblogLink = createLinkElement('z-blog', 'https://www.zblogcn.com/', 'icon-zblog-square-fill', '官网');

    userbtn.insertBefore(zblogLink, userbtn.firstChild);
    userbtn.insertBefore(frontEndLink, userbtn.firstChild);

    let linksToRemove = userbtn.querySelectorAll('a');
    linksToRemove.forEach((link, index) => {
      if (index < linksToRemove.length - 1) {
        let nextNode = link.nextSibling;
        while (nextNode && nextNode.nodeType === 3 && !nextNode.textContent.trim()) {
          nextNode = nextNode.nextSibling;
        }
      }
    });
  }
  // 创建链接元素
  function createLinkElement(className, href, iconClass, text) {
    let link = document.createElement('a');
    link.classList.add(className);
    link.href = href;
    link.target = '_blank';
    link.innerHTML = `<i class="${iconClass}"></i> <span>${text}</span>`;
    return link;
  }

  // 插入返回顶部按钮
  function insertBackToTopButton() {
    let toTop = document.createElement('div');
    toTop.className = 'toptop';
    let iconToTop = document.createElement('i');
    iconToTop.className = 'icon-arrow-up-short';
    toTop.appendChild(iconToTop);
    toTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    document.body.appendChild(toTop);
    toTop.classList.add('hidden');

    window.addEventListener('scroll', function() {
      toTop.classList.toggle('hidden', window.scrollY <= 500);
    });
  }

  beautifyTbUpdateInfo();
  moveThanksList();
  classifyMain2();
  labelIndexPage();
  removeIconsFromThemesAndPlugins();
  highlightMenuItem();
  updateUserModule();
  insertBackToTopButton();
});
