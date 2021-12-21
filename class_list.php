<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍の分類の一覧表示</title>
    </head>
    <body>
        <center>

            検索結果を表示します。<br><br>

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
            select classnum, classname 
            from class";

            // Queryを実行して検索結果をresultに格納
            $result = pg_query($conn, $sql);
            if($result == null){
                print("クエリの実行処理でエラーが発生しました。<br>");
                exit;
            }

            // 検索結果の行数、列数を取得
            $rows = pg_num_rows($result);
            $cols = pg_num_fields($result);

            // 検索結果をテーブルとして表示
            print("<table border=1>\n");

            // 各列の名前を表示
            print("<tr>");
            print("<th>分類番号</th>");
            print("<th>分類名</th>");
            print("</tr>");

            // 各行のデータを表示
            for($i = 0; $i < $rows; $i++){
                print("<tr>");
                for($j = 0; $j < $cols; $j++){
                    $data = pg_fetch_result($result, $i, $j);

                    print("<td>$data</td>");
                }
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
            <a href="index.html">操作メニューに戻る</a>
        </center>
    </body>
</html>