// 设置cookie
export function setCookie(name, value, expire) {
  let date = new Date();
  date.setSeconds(date.getSeconds() + expire);
  document.cookie = name + "=" + escape(value) + "; expires=" + date.toGMTString();
  // console.log(document.cookie);
}

/*获取cookie*/
export function getCookie(name) {
  if (document.cookie.length > 0) {
    // 查询cookie中name是否存在
    let start = document.cookie.indexOf(name + "=");
    if (start !== -1) {
      start = start + name.length + 1;
      let end = document.cookie.indexOf(";", start);
      if (end === -1) end = document.cookie.length;
      return unescape(document.cookie.substring(start, end))
    }
  }
  return ""
}

/*删除cookie*/
export function delCookie(name) {
  setCookie(name, "", -1)
}
