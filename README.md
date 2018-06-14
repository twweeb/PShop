# PShop 購物車

![alt text](https://github.com/twweeb/PShop/blob/master/README/img01.png)

## 目錄

### 一、前言

### 二、安裝與設定網站

### 三、網站基礎架構

### 四、使用者管理

### 五、商品管理

### 六、購物車

### 七、訂單系統

### 八、其他設計與特色

## 一、前言

隨著網路購物的蓬勃發展，未來會有更多虛擬商店，各中小企業為了擴展客源， 需要一個容易操作的購物網站系統，經營者能快速上架貨物，並透過訂單系統管理各筆交易。對顧客而言，一個美觀大方且容易操作的介面，更是我們致力的目標。

我們希望能開發出一套具備完整功能，以及高級使用者體驗舒適、管理方便、功能強大的購物車系統，讓店長只需要專心於上架貨品、出貨，其他關於庫存、訂單管理、報表、優惠、...等功能，能夠透過購物車系統自動完成！

但由於完整的購物車系統，實在過於複雜，兩個月時間內我們只能完成大致上的系統功能，希望在之後能陸續修改與更新。

## 二、安裝與設定網站

PShop購物車安裝程序相當簡單，但仍有一些細節須留意，在這邊一一示範。

**[系統要求]**

- 伺服器最低需求:

- 作業系統: Linux/FreeBSD/Unix 64bit

- 網站伺服器軟體: Apache > 2.4  PHP > 7.0

- 資料庫: MySQL >= 5.6

- 建議瀏覽器版本:

- Chrome: 63

- Firefox: 80

- Safari: 11

- 支援HTML5的瀏覽器

- 解析度建議: 1024x768以上

**[示範環境]**

- 服務端:

- 作業系統: FreeBSD 11.1-RELEASE-p4 amd64 (Unix Like...)

- 網站伺服器軟體: Apache/2.4.29 (FreeBSD) OpenSSL/1.0.2k-freebsd PHP/7.2.3

- 資料庫: MySQL 5.7.21-log

- 請確定您的環境系統符合我們的最低要求，否則安裝無法順利進行！若您確定以上資訊，就可以開始安裝 PShop 購物車，開始吧！

#### 第一步

首先，請先從 https://github.com/twweeb/PShop 下載我們的壓縮檔，並將他移動到您的網站根目錄下，並解壓縮。

ex: /public_html/pshop

假設安裝路徑為 HOMEDIR =>   /public_html/pshop

假設網址對應為位置 WEBURL =>   http://_YOUR_SITE_URL_/pshop/

將 pshop.tar.gz 解壓縮放置 HOMEDIR下

並進入網站網址 WEBURL

系統會指示您完成安裝，若因權限問題無法順利新增設定檔請依指示於網站上完成。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img02.png)


#### 第二步

解壓縮完之後，您可以直接到 WEBURL (網站對應位置)，開始進行安裝。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img03.png)

#### 第三步

首先請先設定資料庫資訊，按照圖中所示，以下資訊可以從主機管理員或您的伺服器提供商取得。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img04.png)

#### 第四步

若您因使用權限而造成系統無法自行建立檔案，請按照圖中所示，將資料夾權限重新設定；或者您可以用文字編輯器，將 /database/db-sample.php 檔案開啟並填寫，之後將該檔案名稱設定為 db.php （同目錄下）。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img05.png)

#### 第五步

若您使順利完成資料庫連線，將可以看到以下頁面，就可以開始安裝了！
![alt text](https://github.com/twweeb/PShop/blob/master/README/img06.png)

#### 第六步

這是安裝過程最後一步，設定基礎網站資訊、管理員帳號後，便能開始使用了！
![alt text](https://github.com/twweeb/PShop/blob/master/README/img07.png)

#### 第七步

順利安裝後，會出現如下畫面，就能開始使用囉！
![alt text](https://github.com/twweeb/PShop/blob/master/README/img08.png)

* ＊伺服器權限設定＊ *

由於您可能會需要上傳商品圖片，建議您將 img/product_img/ , img/product_img/thumb/cache/ 兩個資料夾皆設為 777！
![alt text](https://github.com/twweeb/PShop/blob/master/README/img09.png)

* ＊安全＊ *

為維護您網站的安全，建議您在安裝完成後，將 install/ 資料夾移除！

## 三、網站基礎架構

### 模組架構

** 模組1 使用者 (Class User) **

帳號新增
帳號修改
帳號刪除
帳號管理
密碼變更
登入／登出

**  模組2 商品 (Class Commodity) **

商品新增
商品修改
商品下架
商品庫存
商品已售
商品照片
商品搜尋

** 模組3 商品分類 (Class Cat) **

分類名
分類代號
分類統計

** 模組4 購物車 (Class Cart) **

記錄加入的商品
移除加入的商品
累計購買金額
優惠/折扣
運費
總金額
商品寄送方式
付款方式
購買人資料

** 模組5 訂單 (Class Order) **

確認各項商品庫存
套用優惠確認
訂單狀態
訂單日期
付款狀態
取消訂單 => 回復庫存

** 模組6 優惠 (Class Coupon) **

優惠新增
優惠折扣
優惠期限
優惠數量

** 模組7 網站設定 (Class Option) **

網站名稱
網站細部設定

** 模組8 圖表 (Class Chart) **

後台統計圖表
轉換 json Data
輸出圖表

#### 資料庫關聯
![alt text](https://github.com/twweeb/PShop/blob/master/README/img10.png)

## 四、使用者管理

⋅進入首頁，點選右上角的〝註冊〞，資料填妥後（系統預設為一般買家），即可進行購物。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img11.png "資料庫關聯"

・登入後，點選右上角的〝會員資料〞，可修改個人資料。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img12.png)
![alt text](https://github.com/twweeb/PShop/blob/master/README/img13.png)
![alt text](https://github.com/twweeb/PShop/blob/master/README/img14.png)


・網站管理員登入後，可在後台管理用戶資料（瀏覽用戶資料、刪除用戶、修改用戶權限）。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img15.png)

・點選〝管理後台〞→〝會員管理〞。
![alt text](https://github.com/twweeb/PShop/blob/master/README/img16.png)
![alt text](https://github.com/twweeb/PShop/blob/master/README/img17.png)

## 五、商品管理

・僅有管理員可以對商品進行新增與修改

・開啟管理後台，可以選擇要對商品所進行的操作

・在新增商品的地方，輸入商品基本資訊後，按下新增商品即可將商品成功上架
![alt text](https://github.com/twweeb/PShop/blob/master/README/img18.png)
![alt text](https://github.com/twweeb/PShop/blob/master/README/img19.png)

・商品管理可以觀看商品總上架數量及類別，也可以對商品進行修改或下架
![alt text](https://github.com/twweeb/PShop/blob/master/README/img20.png)

・點選右方圖標則可切換介面，選擇重新要上架的商品
![alt text](https://github.com/twweeb/PShop/blob/master/README/img21.png)

## 六、購物車

・使用者在登入後，才可使用購物車所有功能

・使用者可將自己欲訂購的商品及商品數量，加入購物車
![alt text](https://github.com/twweeb/PShop/blob/master/README/img22.png)

・使用者可以點擊購物車圖示，查看或修改購物車內容
![alt text](https://github.com/twweeb/PShop/blob/master/README/img23.png)

・在購物車內容頁面，刪除不想訂購的商品，並且輸入擁有的折扣代碼，得知訂單總金額
![alt text](https://github.com/twweeb/PShop/blob/master/README/img24.png)

・使用者可以在下單前，修改個人訂購資料，並選擇付款與取貨方式
![alt text](https://github.com/twweeb/PShop/blob/master/README/img25.png)

・下單成功，清空購物車內容，可再次開始選購
![alt text](https://github.com/twweeb/PShop/blob/master/README/img26.png)

## 七、訂單系統

・後台可以查看所有訂單狀況，亦可取消某筆訂單
![alt text](https://github.com/twweeb/PShop/blob/master/README/img27.png)

・管理員/客戶可以查看目前訂單的狀態
![alt text](https://github.com/twweeb/PShop/blob/master/README/img28.png)

・（由於物流/金流細節並未實作）管理員可以從後台直接設定已付款/已出貨
![alt text](https://github.com/twweeb/PShop/blob/master/README/img29.png)

・客戶可以從『首頁』=>『我的訂單』，瀏覽自己的訂單訊息
![alt text](https://github.com/twweeb/PShop/blob/master/README/img30.png)

## 八、其他設計與特色

・月營業額統計表
![alt text](https://github.com/twweeb/PShop/blob/master/README/img31.png)

・即時網站資訊
![alt text](https://github.com/twweeb/PShop/blob/master/README/img32.png)

・優惠管理介面
![alt text](https://github.com/twweeb/PShop/blob/master/README/img33.png)

・商品分類管理
![alt text](https://github.com/twweeb/PShop/blob/master/README/img34.png)

・頁碼設計
![alt text](https://github.com/twweeb/PShop/blob/master/README/img35.png)

・網站一般設定（可於當中設定購物車網站資訊）
![alt text](https://github.com/twweeb/PShop/blob/master/README/img36.png)

﹒建立優惠
![alt text](https://github.com/twweeb/PShop/blob/master/README/img37.png)
