    (function() {
        var now = new Date();
        var warrantyValue = (new Date(now.getFullYear() + 2, now.getMonth(), now.getDay())).toISOString();
        var div = document.getElementById('monetha-buy-button-3900220168644364');
        var btn = document.createElement('a');
        btn.href = 'https://payment.monetha.io/orders/add?pid=monetha-12314&secret=42378467867868737&oid=1234&amount=141.6&currency=USD&return=https://www.monetha.io/en/mvp&cancel=&callback=https://payment.monetha.io/monethabutton/callback&i_firstname=button-purchase&i_lastname=button-purchase&i_email=merchants@monetha.io&i_items=[{ "name": "Bullet", "quantity": 1, "warranty":"' + warrantyValue + '", "price": "120", "subtotal": "120", "total_tax": "21.6", "total": "141.6"}]&i_delivery=post';
        btn.innerText = 'Buy this item';
        btn.setAttribute('style', 'border-radius: 5px;font-weight:400;line-height:1.42857143;text-align:center;touch-action:manipulation;cursor:pointer;border: 1px solid transparent;background-color:#094da0;border-color:#094da0;color:#fff;text-decoration:none;font-size: 15px;padding: 6px 25px;border-radius: 5px;font-weight:400;line-height:1.42857143;text-align:center;touch-action:manipulation;cursor:pointer;border: 1px solid transparent;background-color:#094da0;border-color:#094da0;color:#fff;text-decoration:none;');
        div.appendChild(btn);
    })();