window.onload=()=>
{
    renderProducts();
    getCart();
};
function renderProducts()
{
    let args={action:"load"};
    $.get('../index.php',args,data=>
    {
        data=JSON.parse(data);
        if(data.length==0)
        {
            console.log('load failed');
        }
        else
        {
            for(i in data)
            {
                let spacing="";
                switch(data[i]["product_type"])
                {
                    case 'bike':
                        spacing="col-xs-4 col-md-4";
                        break;
                    case 'accessory':
                        spacing="col-xs-6 col-md-6";
                        break;
                    case 'addon':
                        spacing="col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-4";
                        break;
                }

                $(`#content .${data[i]["product_type"]}`).append(`
                <div class="${spacing}">
                <h4 class=center>$${parseFloat(data[i]["price"]).toFixed(2)}</h4>
                <div class="thumbnail">
                    <img src="${data[i]["image"]}" alt="#pic">
                    <div class="caption">
                        <h3 class=center>${data[i]["name"]}</h3>
                        <p class="center items" id="${data[i]["id"]}">x0</p>
                        <p class=center>
                            <a href="#sub" onclick=handleOrder(${data[i]["id"]},'sub',${data[i]["price"]},"${data[i]["product_type"]}","${(data[i]["name"]).replace(/\s/g,'-')}"); class="btn btn-default" role="button">-</a>
                            <a href="#add" onclick=handleOrder(${data[i]["id"]},'add',${data[i]["price"]},"${data[i]["product_type"]}","${(data[i]["name"]).replace(/\s/g,'-')}"); class="btn btn-primary" role="button">+</a>
                        </p>
                    </div>
                </div>
                </div>
                `);
            }
        }
    });
}
function handleOrder(e,action,price,type,name)
{
    let args={"action":action,"id":e,"product":{"price":price,"type":type,"name":name}};
    $.post('../index.php',args,data=>
    {
        $('#'+e).text('x'+data);
        checkoutReady();
    });

}
function getCart()
{
    let args={action:"reload"};
    $.get('../index.php',args,data=>
    {
        data=JSON.parse(data);
        if(data)
        {
            for(i in data)
            {
                $('#'+i).text('x'+data[i]);
            }
            checkoutReady();
        }
        //else
        //the cart is empty
    });
}
function clearCart()
{
    let args={action:'clearCart'};
    $.get('../index.php',args,data=>
    {
        if(data)
        {
            $('.items').text('x0');
            checkoutReady();
            /* for(let i=1;i<=6;i++)
            {
                $('#'+i).html('x0');
            } 
            */
            //console.log('cart cleared');
        }
    });
}
function checkoutReady()
{
    let abike = Number($('#1').html()[1]);
    let fbike = Number($('#2').text()[1]);
    let kbike = Number($('#3').text()[1]);
    if(abike>=1||fbike>=1||kbike>=1)
    {
        $('#checkout').removeClass('disabled');
    }
    else
    {
        $('#checkout').addClass('disabled');
    }
}
function next()
{
    if(!$('#checkout').hasClass('disabled'))
    {
        window.location.replace('cart.html');
    }
}