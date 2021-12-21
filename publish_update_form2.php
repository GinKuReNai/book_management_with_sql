<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>出版社の更新フォーム</title>
    </head>
    <body>
        <h2>出版社データ 更新フォーム</h2>
        <br><br>

        <form action="publish_update.php" method="get">

        <!-- ここからPHPスクリプトの開始 -->
        <?php
            // フォームから渡された引数を取得
            $publisher = $_GET[publisher];

            // データベースに接続
            $conn = pg_connect("dbname=abcw2059");

            // 接続が成功したかどうか確認
            if($conn == null){
                print("データベース接続処理でエラーが発生しました。<br>");
                exit;
            }

            $sql = sprintf("select publisher, pubpage from publish where publisher = '%s'", $publisher);

            $result = pg_query($conn, $sql);
            if($result == null){
                print("クエリの実行処理でエラーが発生しました。<br>");
                exit;
            }

            $pubpage = pg_fetch_result($result, 0, 1);

            // 出版社フォームを表示
            print("<p>出版社：");
            print("<input type=\"text\" name=\"publisher\" size=\"15\" value='$publisher' readonly></p>");

            // 出版社ページフォームを表示
            print("<p>出版社URL：");
            print("<input type=\"text\" name=\"pubpage\" size=\"15\" value='$pubpage'></p>");

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