<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍の検索フォーム</title>
    </head>
    <body>
        <center>
        <h2>書籍データ 検索フォーム</h2>
        <br><br>

        <p>検索したい書籍の出版社と分類を選択して送信ボタンを押してください。</p>
        <br><br>

        <form action="book_search.php" method="get">

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

            // 出版社の選択のためのリストボックスを表示
            print("<p>出版社：");
            print("<select name=\"publisher\" size=\"1\">");
            print("<option value=\"ALL\">ALL</option>");
            for($i = 0; $i < $rows; $i++){
                $publisher = pg_fetch_result($result, $i, 0);

                print("<option value=\"$publisher\">$publisher</option>");
            }
            print("</select></p>");
            print("<br>");

            // SQLを作成
            $sql = "select classname from class";

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
            print("<option value=\"ALL\">ALL</option>");
            for($i = 0; $i < $rows; $i++){
                $classname = pg_fetch_result($result, $i, 0);

                print("<option value=\"$i\">$classname</option>");
            }
            print("</select></p>");
            print("<br>");

            // 検索結果の開放
            pg_free_result($result);
            // データベースへの接続を解除
            pg_close($conn);
            ?>
            <!-- ここまででPHPスクリプトの終わり -->
            <br>
        
            <input type="submit" value="送信"><br>
        </form>
        <br>
        <a href="index.html">操作メニューに戻る</a>
        </center>
    </body>
</html>