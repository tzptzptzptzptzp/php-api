<?php

$id = $_GET['id'];

include '../src/apiUrl.php';

// cURLセッションを初期化
$ch = curl_init();

// cURLオプションを設定
curl_setopt($ch, CURLOPT_URL, "{$apiUrl}read/?id={$id}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// APIにリクエストを送信しレスポンスを取得
$response = curl_exec($ch);

// レスポンスをデコード
$post = json_decode($response, true);

// cURLセッションを終了
curl_close($ch);

?>

<?php include '../src/head.php'; ?>

<body>

  <div class="wrapper">
    
    <section>
      <article>

        <div class="post">

          <div class="post_content">
            <p class="post_name">ユーザー名：<?php echo $post['username']; ?></p>
            <p class="post_comment">コメント：<?php echo $post['comment']; ?></p>
          </div>

          <div class="post_editor">
            <form class="delete_form ajax_form" action="<?php echo $apiUrl; ?>delete/" method="POST">
              <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
              <button type="submit">削除</button>
            </form>

            <button class="edit_button">編集</button>
            <form class="edit_form ajax_form" action="<?php echo $apiUrl; ?>update/" method="POST">
              <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
              <input type="text" name="new_username" placeholder="新しい名前">
              <input type="text" name="new_comment" placeholder="新しいコメント">
              <button type="submit">更新</button>
            </form>
          </div>

        </div>

      </article>
    </section>

    
  </div>
  <a href="../">戻る</a>

  <script>
    const editButtons = document.querySelectorAll('.edit_button');
    editButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const form = button.nextElementSibling;
        form.classList.toggle('show');
      });
    });

      // フォームの送信を非同期で行う
    const forms = document.querySelectorAll('.ajax_form');
    forms.forEach((form) => {
      form.addEventListener('submit', (e) => {
        e.preventDefault(); // 通常のフォーム送信をキャンセル

        const url = form.getAttribute('action');
        const method = form.getAttribute('method');
        const data = new FormData(form);

        // Ajaxリクエストを作成
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.onload = function() {
          if (xhr.status === 200) {
            // レスポンスを処理
            console.log(xhr.responseText);
            
            // 削除ボタンの場合のみページ遷移
            if (form.classList.contains('delete_form')) {
              location.href = '../';
            } else {
              // 画面を再読み込み
              location.reload();
            }
          } else {
            console.error('リクエストエラー:', xhr.status);
          }
        };
        xhr.onerror = function() {
          console.error('リクエストエラー');
        };
        xhr.send(data);
      });
    });
  </script>
  
</body>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: center;
    justify-content: center;
    width: 100vw;
    height: 100vh;
    background: #FFFFCC;
  }
  .wrapper {
    width: 1000px;
    max-width: 95%;
    padding: 50px;
    background: white;
    border-radius: 30px;
  }
  .input_form {
    margin-bottom: 20px;
  }
  input {
    width: 150px;
    height: 25px;
  }
  button {
    width: 50px;
    height: 25px;
  }
  .post {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 1px solid #aaa;
  }
  .post_editor {
    display: flex;
    gap: 10px;
  }
  .edit_form {
    display: none;
  }
  .edit_form.show {
    display: block;
  }
  @media screen and (max-width: 767px) {
    body {
      height: auto;
      padding: 20px 0;
    }
    .wrapper {
      padding: 30px 20px 10px;
    }
    .input_form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: center;
      padding-bottom: 20px;
      border-bottom: 1px solid #aaa;
    }
    .input_form input {
      width: 80%;
    }
    .post {
      flex-direction: column;
      gap: 10px;
      padding-bottom: 20px;
    }
    .post_editor {
      flex-direction: column;
      align-items: center;
      width: 100%;
    }
    .edit_form {
      flex-direction: column;
      gap: 10px;
      align-items: center;
      width: 100%;
    }
    .edit_form input {
      width: 80%;
    }
    .edit_form.show {
      display: flex;
    }
  }
</style>

<?php include '../src/foot.php'; ?>
