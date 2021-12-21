<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍の追加フォーム</title>
    </head>
    <body>
        <h2>書籍データ 追加フォーム</h2>
        <br><br>

        <form action="book_add.php" method="get">

        <p>タイトル：<input type="text" name="title" size="30"></p>
        <br>
        <!-- ここからPHPスクリプトの開始 -->
        <?php

            // データベースに接続
            $conn = pg_connect("dbname=abcw2059");

            // 接続が成功したかどうか確認
            if($conn == null){
                print("データベース接続処理でエラーが発生しました。<br>");
                exit;
            }

            // SQLを作成
            $sql = "select publisher from publish";

            // Queryを実行して検索結果をresultに格納
            $result = pg_query($conn, $sql);
            if($result == null){
                print("クエリの実行処理でエラーが発生しました。<br>");
                exit;
            }

            // 検索結果の行数を取得
            $rows = pg_num_rows($result);

            // リストボックスとして出版社の選択肢を表示
            print("<p>出版社：");
            print("<select name=\"publisher\" size=\"1\">");
            for($i = 0; $i < $rows; $i++){
                $publisher = pg_fetch_result($result, $i, 0);

                print("<option value=\"$publisher\">$publisher</option>");
            }
            print("</select></p>");
            print("<br>");

            // SQLを作成
            $sql = "select classnum from class";

            // Queryを実行して検索結果をresultに格納
            $result = pg_query($conn, $sql);
            if($result == null){
                print("クエリの実行処理でエラーが発生しました。<br>");
                exit;
            }

            // 検索結果の行数を取得
            $rows = pg_num_rows($result);

            // リストボックスとして分類名の選択肢を表示
            print("<p>分類名：");
            print("<select name=\"classnum\" size=\"1\">");
            for($i = 0; $i < $rows; $i++){
                $data = pg_fetch_result($result, $i, 0);

                print("<option value=\"$i\">$data</option>");
            }
            print("</select></p>");

            // 検索結果の開放
            pg_free_result($result);
            // データベースへの接続を解除
            pg_close($conn);
        ?>
        <!-- ここまででPHPスクリプトの終わり -->
        <br>

        <p>
            著者：
            <input type="text" name="author1" size="10">
            <input type="text" name="author2" size="10">
            <input type="text" name="author3" size="10">
        </p>
        <br>

        <p>読了日：<input type="date" name="finishdate"></p>
        <br>

        <p>
            状態：
            <input type="radio" name="status" value="既読" checked>既読</input>
            <input type="radio" name="status" value="進行中">進行中</input>
            <input type="radio" name="status" value="未読">未読</input>
        </p>
        <br><br>

        <p><input type="submit" value="送信"></p>
        <br>

        </form>
    </body>
</html>