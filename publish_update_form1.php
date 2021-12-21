<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>出版社の更新フォーム</title>
    </head>
    <body>
        <center>
            <h2>出版社データ 更新フォーム</h2>
            <br><br>

            <p>更新したい出版社を選択して送信ボタンを押してください。</p>
            <br><br>

            <form action="publish_update_form2.php" method="get">
                <!-- ここからPHPスクリプトの開始 -->
                <?php
                // データベースに接続
                $conn = pg_connect("dbname=abcw2059");

                // 接続が成功したかどうかの確認
                if($conn == null){
                    print("データベース接続処理でエラーが発生しました。<br>");
                    exit;
                }

                // SQLを作成
                $sql = "
                select publisher, pubpage 
                from publish";

                // Queryを実行して検索結果をresultに格納
                $result = pg_query($conn, $sql);
                if($result == null){
                    print("クエリの実行処理でエラーが発生しました。<br>");
                    exit;
                }

                $rows = pg_num_rows($result);

                // 検索結果をテーブルとして表示
                print("<table border=1>\n");

                // 各列の名前を表示
                print("<tr>");
                print("<th>出版社</th>");
                print("<th>出版社ページ</th>");
                print("</tr>");


                // 各行のデータを表示
                for($i = 0; $i < $rows; $i++){
                    print("<tr>");
                    // 出版社の選択のためのラジオボタンを表示
                    $data = pg_fetch_result($result, $i, 0);
                    print("<td><input type=\"radio\" name=\"publisher\" value=\"$data\">$data</input></td>");
                    $data = pg_fetch_result($result, $i, 1);
                    print("<td><a href=\"$data\">出版社HP</a></td>");
                    print("</tr>");
                }

                // ここまででテーブル終了
                print("</table>");
                print("<br>\n");

                // 検索件数の表示
                print("以上、$rows 件のデータを表示しました。<br>\n");

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