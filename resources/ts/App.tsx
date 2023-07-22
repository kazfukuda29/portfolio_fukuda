import React, { useEffect, useState } from 'react';
import axios from 'axios';


axios.defaults.withCredentials = true; // cookieを送信するための設定


const App: React.FC = () => {
  const [userType, setUserType] = useState(null);

  useEffect(() => {
    // CSRFトークンを取得
    axios.get('/sanctum/csrf-cookie').then(() => {
      // トークン取得後にユーザータイプを取得
      axios.get('/api/user-type')
        .then(response => {
          setUserType(response.data.type);
          console.log(response.data.type);
        });
    });
  }, []);

  return (
    <div>
      {userType === 'admin' ? (
        <p>管理者向けのお知らせを表示</p>
      ) : userType === 'users' ? (
        <p>一般ユーザー向けのお知らせを表示</p>
      ) : (
        <p>ゲストユーザー向けのお知らせを表示</p>
      )}
    </div>
  );
}

export default App;

