import './bootstrap';
import liff from '@line/liff';

window.getUserInfo = () => {
  liff.init({ liffId: import.meta.env.VITE_APP_LIFF_ID }).then(() => {
    if (!liff.isLoggedIn()) {
      liff.login({}) // ログインしていなければ最初にログインする
    }

    liff.getProfile()  // ユーザ情報を取得する
      .then(profile => {
        const userId = profile.userId
        const displayName = profile.displayName
        alert(`Name: ${displayName}, userId: ${userId}`)
      }).catch(function (error) {
        window.alert('Error sending message: ' + error);
      });
  })
}