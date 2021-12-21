<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍の更新フォーム</title>
    </head>
    <body>
        <h2>書籍データ 更新フォーム</h2>
        <br><br>

        <form action="book_update.php" method="get">

        <!-- ここからPHPスクリプトの開始 -->
        <?php
            // フォームから渡された引数を取得
            $index = $_GET[index];

            // データベースに接続
            $conn = pg_connect("dbname=abcw2059");

            // 接続が成功したかどうか確認
            if($conn == null){
                print("データベース接続処理でエラーが発生しました。<br>");
                exit;
            }

            $sql =
            "select book.title, book.publisher, class.classname, book.author1, book.author2, book.author3, publish.pubpage, book.finishdate, book.status
            from book, publish, class
            where book.publisher = publish.publisher and book.classnum = class.classnum";

            $result = pg_query($conn, $sql);
            if($result == null){
                print("クエリの実行結果でエラーが発生しました。<br>");
                exit;
            }

            $title = pg_fetch_result($result, $index, 0);
            $publisher = pg_fetch_result($result, $index, 1);
            $classname = pg_fetch_result($result, $index, 2);
            $author1 = pg_fetch_result($result, $index, 3);
            $author2 = pg_fetch_result($result, $index, 4);
            $author3 = pg_fetch_result($result, $index, 5);
            $pubpage = pg_fetch_result($result, $index, 6);
            $status = pg_fetch_result($result, $index, 7);


            // タイトルを入力するテキストボックスを表示
            print("<p>タイトル：");
            print("<input type=\"text\" name=\"title\" size=\"30\" value=\"$title\" readonly></p>");
            print("<br>");

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
                $data = pg_fetch_result($result, $i, 0);

                if(strcmp($data, $publisher) == 0){
                    print("<option value=\"$data\" selected readonly>$data</option>");
                }
                else{
                    print("<option value=\"$data\" readonly>$data</option>");
                }
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
            for($i = 0; $i < $rows; $i++){
                $data = pg_fetch_result($result, $i, 0);

                if(strcmp($data, $classname) == 0){
                  print("<option value=\"$i\" selected>$data</option>");
                }
                else{
                  print("<option value=\"$i\">$data</option>");
                }
            }
            print("</select></p>");

            // 著者を入力するテキストボックスを表示
            print("<p>著者：");
            print("<input type=\"text\" name=\"author1\" size=10 value=\"$author1\">");
            print("<input type=\"text\" name=\"author2\" size=10 value=\"$author2\">");
            print("<input type=\"text\" name=\"author3\" size=10 value=\"$author3\">");
            print("</p><br>");

            // 読了日を入力するボックスを表示
            print("<p>読了日：");
            print("<input type=\"date\" name=\"finishdate\" value=\"$finishdate\"></input>");
            print("</p><br>");

            // 状態を選択するラジオボタンを表示
            print("<p>状態：");
            if(strcmp($status, "既読") == 0){
                print("<input type=\"radio\" name=\"status\" value=\"既読\" checked>既読</input>");
                print("<input type=\"radio\" name=\"status\" value=\"進行中\">進行中</input>");
                print("<input type=\"radio\" name=\"status\" value=\"未読\">未読</input>");
            }
            else if(strcmp($status, "進行中") == 0){
                print("<input type=\"radio\" name=\"status\" value=\"既読\">既読</input>");
                print("<input type=\"radio\" name=\"status\" value=\"進行中\" checked>進行中</input>");
                print("<input type=\"radio\" name=\"status\" value=\"未読\">未読</input>");
            }
            else{
                print("<input type=\"radio\" name=\"status\" value=\"既読\">既読</input>");
                print("<input type=\"radio\" name=\"status\" value=\"進行中\">進行中</input>");
                print("<input type=\"radio\" name=\"status\" value=\"未読\" checked>未読</input>");
            }
            print("</p><br><br>");

            // 検索結果の開放
            pg_free_result($result);
            // データベースへの接続を解除
            pg_close($conn);
        ?>
        <!-- ここまででPHPスクリプトの終わり -->

        <p><input type="submit" value="送信"></p>
        <br>

        </form>
    </body>
</html>
