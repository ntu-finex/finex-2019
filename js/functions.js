    $( document ).ready(getCash(), getPoints());
    $(document).ready(function(){
        $('.sell-tab').hide();
        $('#stock1_sell,#stock2_sell,#stock3_sell,#stock4_sell').click(function(){
            $('.buy-tab').hide();
            $('.sell-tab').show();
        });
        $('#stock1_buy,#stock2_buy,#stock3_buy,#stock4_buy').click(function(){
            $('.buy-tab').show();
            $('.sell-tab').hide();
        });

    });

    $(document).on('click', ".btn-minuse",function(){
        if($(this).parent().siblings('input').val() <= 0){
            $(this).parent().siblings('input').val(parseInt(0));
        }else{
            $(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) - 1)
        }
    })

    $(document).on('click', '.btn-pluss',function(){
        var qty = $('.companyStock>.quantity').html();
        if($(this).parent().siblings('input').val() == qty){
            $(this).parent().siblings('input').val(parseInt(qty));
        }else{
            $(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) + 1)
        }
    })

    $(document).on('click', ".btn-minuse2",function(){
        if($(this).parent().siblings('input').val() <= 0){
            $(this).parent().siblings('input').val(parseInt(0));
        }else{
            $(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) - 1)
        }
    })

    $(document).on('click', '.btn-pluss2',function(){
        var qty = $('.multipleStock>.quantity').html();
        if($(this).parent().siblings('input').val() == qty){
            $(this).parent().siblings('input').val(parseInt(qty));
        }else{
            $(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) + 1)
        }
    })

    $(document).on('click', '.purchaseBox', purchaseMultipleStocks);


    function cancelStock($id){
        if(!confirm("Are you sure you want to cancel your listing?")){
            return false;
        }

        $.ajax({
            url: 'php/stock_cancel.php',
            method: 'post',
            data:{
                id: $id, //pass in the sale_id
            },
            success:function(response){
                if(response == 'You don\'t have any stock for cancellation.'){
                    alert(response);
                }else{
                    showMultipleStocks(response);
                }
            }
        })
    }

    function sellStock($id){
        var priceStock = prompt("Please enter your listing price");
        if (priceStock == null) {
            return false;
        }else if(priceStock <= 0){
            alert("The price is invalid");
            return false;
        }

        $.ajax({
            url: 'php/stock_sell.php',
            type: 'post',
            data:{
                id: $id,
                price: priceStock,
            },
            success:function(response){
                if(response == 'You don\'t have any stock for sale.'){
                    alert(response);
                }else{
                    alert("The stock "+response+" has been listed for sale.");
                    showMultipleStocks(response);
                }
            }
        })
    }

    function sellMultipleStocks($stockName){
        var qtys = $('.sellMultipleStocks');
        var qty = 0;
        for(var i = 0; i < qtys.length; i++){
            if($(qtys[i]).val() != 0){
                qty = $(qtys[i]).val(); //number of stocks that you want to sell :)
            }
        }

        if(qty <= 0){
          alert("The quantity entered is invalid!");
          return false;
        }

        var priceStock = prompt("Please enter your listing price for one stock.");
        if (priceStock == null) {
            return false;
        }else if(priceStock <= 0){
            alert("The price is invalid!");
            return false;
        }

        $.ajax({
            url: 'php/stock_sell.php',
            type: 'post',
            data:{
                name: $stockName,
                quantity: qty,
                price: priceStock,
            },
            success:function(response){
                if(response == 'You don\'t have any stock for sale.'){
                    alert(response);
                }else if(response == 'You don\'t have sufficient stock for sale.'){
                    alert(response);
                }else if(response == 'You have already listed 5 stocks for sale'){
                    alert(response);
                }else{
                    alert("The stock "+response+" has been listed for sale.");
                    showMultipleStocks(response);
                }
            }
        })

    }

    function purchaseStock($sale_id){
        if(!confirm("Are you sure you want to purchase this stock?")){
            return false;
        }
        $.ajax({
            url:'php/stock_purchase.php',
            type: 'post',
            data:{
                id: $sale_id,
            },
            success:function(result){
                if(result === 'Stock is unavailable for purchase.' || result === "You don't have enough cash to purchase the stocks."){
                    alert(result);
                }else{
                    getCash();
                    alert("You have successfully purchased the stock!");
                    showStocks(result);
                }
            }
        });
    }

    function purchaseMultipleStocks(){
      var sale_id = "";
      sale_id = $(this).attr('class').split(/\s+/)[5]; //get the sale_id here

      var seller = $(this).find('.seller').text();

      if(!confirm("Are you sure you want to purchase this stock?")){
          return false;
      }

      $.ajax({
        url: 'php/purchaseMultipleStocks.php',
        type: 'post',
        data:{
          sale_id : sale_id,
          seller: seller,
        },
        success: function(response){
          if(response == "You don't have enough cash to purchase the stocks."){
            alert(response);
          }else{
            alert("You've successfully purchased the stock!");
            getCash();
            showStocks(response);
          }
        }
      });
    }

    function purchaseCompanyStock(stockName){
        var qtys = $('.form-control');
        var qty = 0;
        for(var i = 0; i < qtys.length; i++){
            if($(qtys[i]).val() != 0){
                qty = $(qtys[i]).val();
            }
        }
        var price = $('.price').html();
        var total_price = price*qty;
        if(confirm("Proceed with the purchase?\nThe total price is "+total_price+".")){
            if(qty <= 0){
                alert("The quantity entered is invalid.");
            }else{
                $.ajax({
                    url: 'php/purchaseCompanyStocks.php',
                    type: 'post',
                    data:{
                        quantity: qty,
                        stock: stockName,
                        owner: stockName,
                    },
                    // dataType: 'json',
                    success:function(result){
                        if(result === 'Stock is unavailable for purchase.' || result === "You don't have enough cash to purchase the stocks." || result === 'Insufficient stock for purchase.'){
                            alert(result);
                        }else{
                            getCash();
                            alert("You have successfully purchase the stocks!");
                            showStocks(result);
                        }
                    }
                })
            }
        }else{
            alert("The purchase is cancelled.");
        }

    }


    function getCash(){
        $.ajax({
            url: 'php/stats.php',
            type: 'post',
            data:{
                choice: 1,
            },
            success:function(result){
                //console.log(result);
                $('#cash-result').html(parseFloat(result));
            }
        })
    }

    function getPoints(){
        $.ajax({
            url: 'php/stats.php',
            type: 'post',
            data:{
                choice: 2,
            },
            success:function(result){
                $('#points-result').html(result)
            }
        })
    }

    /*
      Usage: Show all the stocks on the buy tab, according to the sale_id and different users.
    */
    function showStocks($stockName){
        jQuery('.STOCK1S').empty();
        jQuery('.STOCK2S').empty();
      var arrayOwner = [];
        $.ajax({
            url: 'php/stock_show.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){
                
                var counter = 0;
                var companyStock = "";
                var stocks = "";
                var sale_1_div = "";
                var sale_2_div = "";
                var sale_3_div = "";
                var sale_4_div = "";
                var sale_5_div = "";

                var arrayCompanyStock = result.filter(function(value){ //filter out the company stock
                  return value['name'] == value['owner'];
                });

                var arrayUserListings = result.filter(function(value){ //filter out all the user listings
                  return value['name'] !== value['owner'];
                });

                var arraySellerName = arrayUserListings.map(item => item.owner).filter(function(value,index,self){
                  return self.indexOf(value) === index;
                }); //filter out the seller names (not including company's);


                $.each(arraySellerName, function(index,value){
                  var owner = value;

                sale_1_div = sale_2_div = sale_3_div = sale_4_div = sale_5_div = "";
                  //sale_1 contains the listing that has sale_1 as 1
                  var sale_1 = arrayUserListings.filter(function(value){
                    return value['sale_1'] == 1 && value['owner'] == owner;
                  });

                  if(sale_1.length != 0){
                    sale_1_div = '<button class="btn col-xs-3 stocks_box alert purchaseBox sale_1">' + '<strong>' +
                    sale_1[0]['name'] +'</strong>'+'<br>Quantity: '+ sale_1.length + '<br>Price: ' + sale_1[0]['price']*sale_1.length + '<br><span class="seller">' +
                    sale_1[0]['owner'] + '</span><br>' +'</button>' + '<hr>';
                  }

                  //sale_2
                  var sale_2 = arrayUserListings.filter(function(value){
                    return value['sale_2'] == 1 && value['owner'] == owner;
                  });

                  if(sale_2.length != 0){
                    sale_2_div = '<button class="btn col-xs-3 stocks_box alert purchaseBox sale_2">' + '<strong>' +
                    sale_2[0]['name'] +'</strong>'+'<br>Quantity: '+ sale_2.length + '<br>Price: ' + sale_2[0]['price']*sale_2.length + '<br><span class="seller">' +
                    sale_2[0]['owner'] + '</span><br>' +'</button>' + '<hr>';
                  }

                  //sale_3
                  var sale_3 = arrayUserListings.filter(function(value){
                    return value['sale_3'] == 1 && value['owner'] == owner;
                  });

                  if(sale_3.length != 0){
                    sale_3_div = '<button class="btn col-xs-3 stocks_box alert purchaseBox sale_3">' + '<strong>' +
                    sale_3[0]['name'] +'</strong>'+'<br>Quantity: '+ sale_3.length + '<br>Price: ' + sale_3[0]['price']*sale_3.length + '<br><span class="seller">' +
                    sale_3[0]['owner'] + '</span><br>' +'</button>' + '<hr>';
                  }

                  //sale_4
                  var sale_4 = arrayUserListings.filter(function(value){
                    return value['sale_4'] == 1 && value['owner'] == owner;
                  });

                  if(sale_4.length != 0){
                    sale_4_div = '<button class="btn col-xs-3 stocks_box alert purchaseBox sale_4">' + '<strong>' +
                    sale_4[0]['name'] +'</strong>'+'<br>Quantity: '+ sale_4.length + '<br>Price: ' + sale_4[0]['price']*sale_4.length + '<br><span class="seller">' +
                    sale_4[0]['owner'] + '</span><br>' +'</button>' + '<hr>';
                  }

                  //sale_5
                  var sale_5 = arrayUserListings.filter(function(value){
                    return value['sale_5'] == 1 && value['owner'] == owner;
                  });

                  if(sale_5.length != 0){
                    sale_5_div = '<button class="btn col-xs-3 stocks_box alert purchase sale_5">' + '<strong>' +
                    sale_5[0]['name'] +'</strong>' +'<br>Quantity: '+ sale_5.length + '<br>Price: ' + sale_5[0]['price']*sale_5.length + '<br><span class="seller">' +
                    sale_5[0]['owner'] + '</span><br>' +'</button>' + '<hr>';
                  }

                  stocks = stocks + sale_1_div + sale_2_div + sale_3_div + sale_4_div + sale_5_div; //concatenate all the listings
                });

                if(arrayCompanyStock.length != 0){
                    price = arrayCompanyStock[0]['price'];
                    companyStock = "<div class='btn btn-primary companyStock'>"+$stockName+"<br>"+$stockName+"<br>Price: "+"<span class='price'>"+price+"</span >"+"<br>"+"available: "+"<span class='quantity'>" +arrayCompanyStock.length+"</span>"+"<br>"+ '<div class="input-group"><span class="input-group-btn"><button class="btn btn-white btn-minuse" type="button">-</button></span><input type="number" class="form-control no-padding add-color text-center height-25" maxlength="3" value="0"><span class="input-group-btn"><button class="btn btn-red btn-pluss" type="button">+</button></span></div>'+"<button class='btn btn-success btn-purchase' onclick='purchaseCompanyStock(\"" + $stockName + "\")'>Purchase</button>"+"</div><br>"
                }

                if(companyStock != ""){
                    $(".STOCK2S").append(companyStock).hide().fadeIn(700);
                }
                if(stocks != ""){
                    jQuery('.STOCK1S').empty();
                    $(".STOCK1S").append(stocks).hide().fadeIn(700); //Value as a specific item from list.
                }
            }
        })
    }

    /* function showStocksOwned($stockName){
        $.ajax({
            url: 'php/stock_owned.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){
                jQuery('.stocks-owned').empty();
                var length = 0;
                length = result.length;
                $('.ownedQty').html(length);
                $.each(result, function(key, value) { //for each value in list will be in value
                    var name = value['name'];
                    var owner = value['owner'];
                    var id = value['id'];
                    var available = value['available'];
                    if(available == 1){
                        status = "Listed";
                    }else{
                        status = "Not listed";
                    }
                    const color = available == 0 ? "'btn col-xs-3 stocks_box alert' style='background:green;color:white;'":
                    "'btn col-xs-3 stocks_box alert' style='background:red;color:white;'";

                    var sell = '<button onclick="sellStock(\'' + id + '\')" class=' + color + '>' + value['name'] + '      ' + '<br>' + value['price'] + '<br>' + status + '<br>'+
                        '</button>';

                    var cancel = '<button onclick="cancelStock(\'' + id + '\')" class=' + color + '>' + value['name'] + '      ' + '<br>' + value['price'] + '<br>' + status + '<br>'+
                        '</button>';

                    if(available == 0){
                        var div = sell;
                    }else{
                        var div = cancel;
                    }

                    $(".stocks-owned").append(div).hide().fadeIn(700); //Value as a specific item from list.
                });

            }
        })
    } */

    function showMultipleStocks($stockName){
        jQuery('.stocks-owned').empty();
        jQuery('.ownedQty').empty();
        var stocks = "";
        var length = 0; //stocks available for sale / not listed yet
        var div = "";
        var array = [];
        $.ajax({
            url: 'php/stock_for_sale.php',
            type: 'GET',
            data:{
                name: $stockName,
            },
            dataType: 'json',
            success:function(result){ //returns all the stocks owned
                

                $.each(result, function(key, value) { //for each value in list will be in value
                    var name = value['name'];
                    var id = value['id'];
                    var available = value['available'];
                    var sale_1 = value['sale_1'];
                    var sale_2 = value['sale_2'];
                    var sale_3 = value['sale_3'];
                    var sale_4 = value['sale_4'];
                    var sale_5 = value['sale_5'];

                    for(var i = 0; i < 5; i++){
                        array.push([]);
                    }

                    if(sale_1 == 1){ //group them into their array
                        array[0].push(value);
                    }else if(sale_2 == 1){
                        array[1].push(value);
                    }else if(sale_3 == 1){
                        array[2].push(value);
                    }else if(sale_4 == 1){
                        array[3].push(value);
                    }else if(sale_5 == 1){
                        array[4].push(value);
                    }

                    var cancel = "";

                    if(available == 1){
                        status = "Listed";
                    }else{
                        length++;
                    }

                });
                stocks = "<div class='btn btn-primary multipleStock'>"+$stockName+
                "</span >"+"<br>"+"available: "+"<span class='quantity'>" +length+
                "</span>"+"<br>"+ '<div class="input-group"><span class="input-group-btn"><button class="btn btn-white btn-minuse2" type="button">-</button></span><input type="number" class="form-control sellMultipleStocks no-padding add-color text-center height-25" maxlength="3" value="0"><span class="input-group-btn"><button class="btn btn-red btn-pluss2" type="button">+</button></span></div>'+"<button class='btn btn-danger btn-purchase' onclick='sellMultipleStocks(\"" + $stockName + "\")'>List it!</button>"+"</div>" ;

                const color = "'btn col-xs-3 stocks_box alert' style='background:red;color:white;'";
                //loop through the 5 different sale_id
                if(result.length != 0){
                  for(var i = 0; i < 5; i++){
                      var cancel = "";
                      var id = "";
                      var status = "Listed";
                      if(array[i][0] !== undefined || array[i].length !== 0){
                          switch(i){
                              case 0: id = "sale_1"; break;
                              case 1: id = "sale_2"; break;
                              case 2: id = "sale_3"; break;
                              case 3: id = "sale_4"; break;
                              case 4: id = "sale_5"; break;
                          }
                          cancel = '<button onclick="cancelStock(\'' + id + '\')" class=' + color + '>' + $stockName + '      ' + '<br>Quantity: '+array[i].length+'<br>Price: ' + array[i][0]['price']*array[i].length + '<br>' + status + '<br>'+
                          '</button>';
                      }
                      div += cancel;
                  }
                }

                if(div != ""){
                    div = "<hr>"+div;
                }

                stocks = stocks + div;
                $('.ownedQty').html(length);
                $(".stocks-owned").append(stocks).hide().fadeIn(700); //Value as a specific item from list.
            }
        })
    }
