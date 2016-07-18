<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="view/stylesheet/order_volusion.css" />
<?php echo $column_left; ?>
<div id="content" class="volusion-style">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div id="pagelabel">
      <span id="print_pagename">Order <?php echo $order_id?></span>
      <span class="v13-titlenote order-placedon"><span title="Placed On: <?php echo $date_added?>"><strong>Placed:</strong> <?php echo $date_added?></span></span>
      <span class="v13-titlenote order-lastmodified" title="Modified: <?php echo $date_modified?>  by <?php echo $firstname . ' ' . $lastname?>"><strong>Modified:</strong> <?php echo $date_modified?>  by <?php echo $firstname . ' ' . $lastname?></span>
      <span id="print_pagesubnav"><span class="separator">|&nbsp;</span></span>
    </div>
    <form action="" method="POST" id="order_form">
      <input type="hidden" name="customer_id" value="<?php echo $customer_id?>">
      <table class="table-statusandquickjump">
        <tbody>
          <tr>
            <td class="cell-status">
              <span class="label-inline">Status</span>
              
              <select id="order_status_id" class="statusselect" name="order_status_id" onchange="ShowSave();">
                <?php foreach($order_statuses as $status) { ?>
                  <option value="<?php echo $status['order_status_id']?>" <?php echo $status['order_status_id']==$order_status_id ? "selected":""?>><?php echo $status['name']?><?php echo ($status['order_status_id']==$order_status_id && $date_shipped) ? (' ' . date('m/d/Y h:iA', strtotime($date_shipped))):'' ?></option>
                <?php } ?>
              </select>
              
              <?php if(!$date_shipped) { ?>
              <a href="<?php echo $act_complete_order . '&amp;email='.$email.'&amp;order_id='.$order_id?>" class="v13-button-primary">Complete Order</a>
              <?php } else { ?>
              <a href="javascript:void(0);" class="v13-button-secondary v13-button-check"><span class="v13-icon-check"></span>Order Complete</a>
              <?php } ?>
            </td>
            
            <td class="cell-nextprevious">            
              <table>
                <tbody><tr>
                  <td>
                    Quick Jump&nbsp;&nbsp;
                  </td>
                  <td class="cell-quickjump">
                    <input type="text" class="input-quickjump" name="order_jump_field" id="order_jump_field" autocomplete="off" style="width: 50px;" value="<?php echo $order_id?>"><a onclick="window.location.href='<?php echo $act_jump?>&order_id='+$('#order_jump_field').val();" href="javascript:" class="v13-button-secondary">Go</a>
                  </td>

                  <script type="text/javascript">
                      $('#order_jump_field').keypress(function (e) {
                          if (e.which == "13") {
                              e.preventDefault();
                              window.location.href = '<?php echo $act_jump?>&order_id=' + $(this).val();
                          }
                      });
                  </script>
                
                  <td class="cell-prevlistnext">
                    <span class="v13-combobutton-secondary">

                      <a href="<?php echo $act_jump . '&order_id=' . ($order_id-1)?>" class="notext"><span class="v13-icon-previous">previous</span></a>
                      <a href="<?php echo $act_list?>" class="notext"><span class="v13-icon-list">list</span></a>
                      <a href="<?php echo $act_jump . '&order_id=' . ($order_id+1)?>" class="notext"><span class="v13-icon-next">next</span></a>
                    </span>
                  </td>
                </tr>
              </tbody></table>
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table-orderdetails summary">
        <tbody>
          <tr valign="top">
            <td class="cell-totalandfraudwrapper">
              <table class="table-totalandfraud">
                <tbody><tr>
                  <td class="cell-fraudenabled">
                    <table class="table-standard">
                      <tbody><tr>
                        <td class="cell-ordertotallabel">
                          <div>
                            <span class="summary subheading">Order Total</span></div>
                        </td>
                        <td class="cell-fraudtotallabel">
                          
                          <div>
                            <span class="summary subheading">Fraud Score</span>
                          </div>
                          
                        </td>
                      </tr>
                      <tr>
                        <td class="cell-ordertotal">
                          <div id="dynordertotal"><span class="summarygrandtotal" style="padding-right:0px;"><?php echo $total?></span></div>
                        </td>
                        <td class="cell-fraudtotal">
                          
                          <div class="fraudriskandactionlinkswrapper">
                            <table>
                              <tbody><tr>
                                <td>
                                  <div id="fraudrisk">
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  
                                  <span>Unavailable with PHONE Orders</span>
                                                              
                                </td>
                              </tr>
                            </tbody></table>
                          </div>
                          
                        </td>
                      </tr>
                    </tbody></table>
                    
                    <div class="customerdetailswrapper">
                      
                      <p>
                        <b>Customer ID#:</b>&nbsp;
                        <?php if($customer_id > 0) { ?>
                        <a href="<?php echo $act_customer . '&customer_id='.$customer_id?>" target="_customer_edit"><?php echo $customer_id?></a>
                        <?php } else { ?>
                        Not Registered
                        <?php } ?>
                        placed <span class="blue"><a href="javascript:;">1 orders</a></span> totaling <span class="green">$1,257.59</span>.
                      </p>

                      <p>This order was placed via <?php echo $user_agent?>
                        <!-- default show the ip note and link -->
                        via IP Address <a onclick="return confirm('Clicking OK will navigate you away from this site. We cannot be responsible for the content of the visiting site.');" class="externalLinkBlue" href="http://whois.domaintools.com/<?php echo $ip?>" target="_blank" title="Click to perform a WHOIS search for this IP"><?php echo $ip?></a>.
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody></table>
              <div>
                <table class="table-billingandshipping">
                  <tbody>
                    <tr valign="top">
                      <td>                
                        <div>
                          <span class="customer_title">Billing
                            <?php if($customer_id > 0) { ?>
                            <a class="actionlink" href="<?php echo $act_customer . '&customer_id='.$customer_id?>" target="_customer_edit">Edit</a>&nbsp;|
                            <?php } ?>
                            <span class="map"><a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=&amp;q=<?php echo $payment_address_1 . ' ' . $payment_address_2 . '+' . $payment_city . ',+' . $payment_zone . '+' . $payment_postcode?>+&amp;ie=UTF8&amp;iwloc=addr" target="_blank" class="externalLinkBlue actionlink">Map It</a></span> </span>
                        </div>
                        <p>
                          <?php echo $payment_company?><br>
                          <?php echo $payment_firstname?>&nbsp;<?php echo $payment_lastname?><br>
                          <?php echo $payment_address_1?>&nbsp;<?php echo $payment_address_2?><br>
                          <?php echo $payment_city?>,
                          <?php echo $payment_zone?>&nbsp;<?php echo $payment_postcode?><br>
                          <?php echo $payment_country?><br>
                          <?php echo $telephone?><br>
                          <a href="mailto:<?php echo $email?>?subject=RE: proaudiola.com : Order %23<?php echo $order_id?>">
                            <?php echo $email?></a>
                        </p>              
                      </td>
                      <td>
                        <div>
                          <span class="customer_title">Shipping
                            <?php if($customer_id > 0) { ?>
                            <a class="actionlink" href="<?php echo $act_customer . '&customer_id='.$customer_id?>" target="_customer_edit">Edit</a>&nbsp;|
                            <?php } ?>
                            <span class="map"><a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=&amp;q=<?php echo $shipping_address_1 . ' ' . $shipping_address_2 . '+' . $shipping_city . ',+' . $shipping_zone . '+' . $shipping_postcode?>&amp;ie=UTF8&amp;iwloc=addr" target="_blank" class="externalLinkBlue actionlink">Map It</a> </span>
                          </span>
                        </div>
                        <p>
                          <?php echo $shipping_company?><br>
                          <?php echo $shipping_firstname?>&nbsp;<?php echo $shipping_lastname?><br>
                          <?php echo $shipping_address_1?>&nbsp;<?php echo $shipping_address_2?><br>
                          <?php echo $shipping_city?>,
                          <?php echo $shipping_zone?>&nbsp;<?php echo $shipping_postcode?><br>
                          <?php echo $shipping_country?><br>
                          <?php echo $telephone?><br>
                          <a href="mailto:<?php echo $email?>?subject=RE: proaudiola.com : Order %23<?php echo $order_id?>">
                            <?php echo $email?></a>
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
            <td valign="top" align="left">
              <div>
                <table class="table-standard">
                  <tbody><tr valign="middle">
                    <td class="cell-printheading">
                      <span class="customer_title gray">Print</span>
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td class="printerarea">
                      <ul>
                        
                        <li><a class="externalLinkBlue" href="javascript:;" target="_blank">Invoice</a></li>
                        <li><a class="externalLinkBlue" href="javascript:;" target="_blank">Packing Slip</a></li>
                        <li id="gift_certificate_item"></li>
                      </ul>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <div class="shippingWrapper">
                <table class="table-standard">
                  <tbody><tr valign="middle">
                    <td class="printerarea">
                      <ul>
                        <li><a href="javascript:;">FedEx</a>&nbsp;&nbsp;&nbsp;&nbsp;|</li>
                        <li><a href="javascript:;">DHL</a>&nbsp;&nbsp;&nbsp;&nbsp;|</li>
                        <li><a href="javascript:;">USPS</a>&nbsp;&nbsp;&nbsp;&nbsp;|</li>
                        <li><a href="javascript:;">Address</a></li>
                      </ul>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <hr noshade="noshade" class="hrule-standard">
              <div class="emailWrapper">
                <table class="table-standard">
                  <tbody><tr valign="middle">
                    <td class="cell-emailoptions">
                      <span class="label-inline">Email</span>
                      <select name="PreDefinedEmails">
                        <option value="">Select</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Partially_Shipped">Partially Shipped</option>
                        <option value="Invoice_Customer">Invoice (to Customer)</option>
                        <option value="Invoice_Vendor">Invoice (to Merchant)</option>
                        <option value="Product_Keys">Product Keys</option>
                        <option value="Gift_Certificates">Gift Certificates</option>
                      </select>
                      <div style="display: none;">
                        <input type="submit" value="Send" name="Send_PreDefinedEmails" id="Send_PreDefinedEmails">
                      </div>
                      <a style="margin-left: 10px;" href="javascript:void(0);" class="v13-button-secondary">Resend</a>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <hr noshade="noshade" align="left" class="hrule-standard">
              <div style="margin-top: 15px; margin-bottom: 15px;">
                <script type="text/javascript">

                  function selectFolderMenu(element) {
                    var folderMenuTabs = getFolderMenuTabs(element);
                    var folderMenuContainer = getFolderMenuContainer(folderMenuTabs);
                    var folderMenuContent = getFolderMenuContent(folderMenuContainer);
                    var tabParent = element.parentNode;

                    if (element.className.indexOf('selected') == -1) {
                      element.className += ' selected';
                      element.className = element.className.replace(/tr/g, '');
                      element.className = element.className.replace(/tl/g, '');
                    }

                    var Item = 0;
                    var ItemBorderSwitch = false;
                    for (var i = 0, x = 0, tabPos = 0; i < tabParent.childNodes.length; i++) {
                      var curNode = tabParent.childNodes[i];
                      if (curNode.nodeName.toLowerCase() == 'li') {
                        x++;
                        
                        if (curNode == element) {
                          tabPos = x;
                          ItemBorderSwitch= true;
                        }
                        else {
                          if (curNode.className.indexOf('selected') != -1) {
                            curNode.className = curNode.className.replace(/selected/g, '');
                          }
                          
                          if(!ItemBorderSwitch)
                          {
                            if (curNode.className.indexOf('tr') != -1) {
                              curNode.className = curNode.className.replace(/tr/g, 'tl');
                            }else{
                              curNode.className += ' tl';
                            }
                          }else{
                            if (curNode.className.indexOf('tl') != -1) {
                              curNode.className = curNode.className.replace(/tl/g, 'tr');
                            }else{
                              curNode.className += ' tr';
                            }
                          }
                        }
                        
                        
                      }
                    }
                        
                    for (var i = 0, x = 0; i < folderMenuContent.childNodes.length; i++) {
                      if (folderMenuContent.childNodes[i].nodeName.toLowerCase() == 'div') {
                        x++;
                        if (x == tabPos) {
                          folderMenuContent.childNodes[i].style.display = 'block';
                        }
                        else {
                          folderMenuContent.childNodes[i].style.display = 'none';
                        }
                      }
                    }
                  }

                  function getFolderMenuTabs(element) {
                    return element.parentNode;
                  }

                  function getFolderMenuContainer(element) {

                    if (element.className.indexOf('folder_menu_tabs') != -1) {
                      return element.parentNode;
                    }
                    else if (element.className.indexOf('folder_menu_container') != -1) {
                      return element;
                    }
                    else  {
                      return getFolderMenuTabs(element).parentNode;
                    }
                  }

                  function getFolderMenuContent(element) {

                    var folderMenuContainer = getFolderMenuContainer(element);

                    for (var i = 0; i < folderMenuContainer.childNodes.length; i++) {
                      if (folderMenuContainer.childNodes[i].nodeName.toLowerCase() == 'div') {
                        return folderMenuContainer.childNodes[i];
                      }
                    }
                  }

                  function selectDefFolderMenu(folderGroupName) {
                    var FolderGroupCookie = GetCookie('vsettings','FolderGroup' + folderGroupName);
                    if (FolderGroupCookie) {
                      document.getElementById(FolderGroupCookie).onclick();
                    }
                  }

                  function setDefFolderMenu(folderGroupName, element) {
                    SetCookie('vsettings', element.id, 1 * c_years, 'FolderGroup' + folderGroupName);
                  }
                </script>

                <div class="folder_menu_container">
                  <ul class="v13-tabset" id="ordernotetabs">
                    <li class="v13-tab v13-selected">
                      <a href="javascript:;" data-target="#tab_ordernotes">
                        <?php if($comment) { ?>
                        <span class="v13-icon-notespresent"></span>
                        <?php } else { ?>
                        <span class="hidden"></span>
                        <?php } ?>
                        Order Notes
                      </a>
                    </li>
                    <li class="v13-tab">
                      <a href="javascript:;" data-target="#tab_privatenotes">
                        <?php if($internal_comment) { ?>
                        <span class="v13-icon-notespresent"></span>
                        <?php } else { ?>
                        <span class="hidden"></span>
                        <?php } ?>
                        Private Notes
                      </a>
                    </li>
                    <li class="v13-tab">
                      <a href="javascript:;" data-target="#tab_giftnotes">
                        <?php if($gift_comment) { ?>
                        <span class="v13-icon-notespresent"></span>
                        <?php } else { ?>
                        <span class="hidden"></span>
                        <?php } ?>
                        Gift Notes
                      </a>
                    </li>
                    <li class="v13-tab">
                      <a href="javascript:;" data-target="#tab_account">
                        <?php if($customer_comment) { ?>
                        <span class="v13-icon-notespresent"></span>
                        <?php } else { ?>
                        <span class="hidden"></span>
                        <?php } ?>
                        Account
                      </a>
                    </li>
                  </ul>
                  <div class="folder_menu_content">
                    <div class="folder_menu_item" id="tab_ordernotes" style="display: block;">
                      <textarea id="comment" name="comment" style="width: 98%; overflow: visible;" rows="6" class="texpand1_small" onchange="ShowSave();" onkeyup="ShowSave();"><?php echo $comment?></textarea>
                    </div>
                    <div class="folder_menu_item" id="tab_privatenotes" style="display: none;">
                      <textarea id="internal_comment" name="internal_comment" style="width: 98%; overflow: visible;" rows="6" class="texpand1_small" onkeyup="ShowSave()" onchange="ShowSave();"><?php echo $internal_comment?></textarea>
                    </div>
                    <div class="folder_menu_item" id="tab_giftnotes" style="display: none;">
                      <textarea id="gift_comment" name="gift_comment" style="width: 98%; overflow: visible;" rows="6" class="texpand1_small" onkeyup="ShowSave()" onchange="ShowSave();"><?php echo $gift_comment?></textarea>
                    </div>
                    <div class="folder_menu_item" id="tab_account" style="display: none;">
                      <?php if($customer_id > 0) { ?>
                      <textarea id="customer_comment" name="customer_comment" style="width: 98%; overflow: visible;" rows="6" class="texpand1_small" onkeyup="ShowSave()" onchange="ShowSave();"><?php echo $customer_comment?></textarea>
                      <?php } else { ?>
                      There are no customer notes
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

              <script type="text/javascript">
                  jQuery(document).ready(function ($) {
                      $('#ordernotetabs li a').click(function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        $('#ordernotetabs li').removeClass('v13-selected');
                        $('.folder_menu_content .folder_menu_item').hide();
                        var target = $(this).attr('data-target');
                        $(this).parent('li').addClass('v13-selected');
                        $('.folder_menu_content ' + target).fadeIn(300);
                      });
                  });
              </script>
              
            </td>
          </tr>
        </tbody>
      </table>    
    </form>
    <div class="a65chromepanel" id="a65chromepanel_1"><!--to line 1000-->
      <div class="a65chromeheader" id="a65chromeheader_1">
        <span class="a65chromeheadertext">
          <span class="arrow_link rotate_arrow" id="arrow_link_1">
            <span class="v13-icon-downarrow"></span>
          </span>Payments
        </span>
      </div>
      <div class="a65chromecontent" id="OrderDetails_detail_page_section___detail_page_section_1" style="">
        <br>
        
        <table class="table-standard contenttable">    
          <tbody>
            <tr valign="top">  

              <td class="cell-paymentsandcredits">  
                <div class="contentareanoscrollstyle" id="PaymentsAndCredits"> 

                  <form name="form_payment_new" id="form_payment_new" action="" method="POST">
                    <div class="new_record">
                        <div class="one_row">
                          <label for="pay_type">Payment Type <em>*</em></label>
                          <select name="pay_type" id="pay_type">
                            <option value="credit_card">Credit Card</option>
                            <option value="paypal">Paypal</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="wire">Wire Transfer</option>
                            <option value="bank">Bank Deposit</option>
                            <option value="other">Other</option>
                          </select>
                        </div>
                        <div class="one_row">
                          <label for="pay_amount" style="width:140px;">Pay Amount <em>*</em></label>
                          <input type="text" name="pay_amount" id="pay_amount" />
                            </div>
                            <div class="one_row pay_credit_card">
                          <label for="sel_credit_card">Use a Saved Card</label>
                          <select name="sel_credit_card" id="sel_credit_card">
                            <?php echo $savedCcHtml; ?>
                          </select>
                        </div>
                        <div class="one_row pay_credit_card">
                          <label for="pay_cc_number">Card Number <em>*</em></label>
                          <input type="text" name="pay_cc_number" id="pay_cc_number" />
                            </div>
                            <div class="one_row pay_credit_card">
                          <label for="pay_cc_type">Credit Card Type <em>*</em></label>
                          <select name="pay_cc_type" id="pay_cc_type" style="width:120px;">
                            <option value="4">Visa</option>
                            <option value="5">MasterCard</option>
                            <option value="3">Amex</option>
                            <option value="6">Discover</option>
                          </select>
                        </div>
                        <div class="one_row pay_credit_card">
                          <label for="pay_cc_name">Name on Card <em>*</em></label>
                          <input type="text" name="pay_cc_name" id="pay_cc_name" />
                        </div>
                        <div class="one_row pay_credit_card">
                          <label for="pay_exp_month">Expiration Date <em>*</em></label>
                          <select name="pay_exp_month" id="pay_exp_month" style="width:75px;">
                            <option value="">Month</option>
                            <?php for($i=1;$i<=12;$i++) { ?>
                            <option value="<?php echo sprintf('%02d', $i)?>"><?php echo sprintf('%02d', $i)?></option>
                            <?php } ?>
                          </select>
                          &nbsp;/&nbsp;
                          <select name="pay_exp_year" id="pay_exp_year" style="width:85px;">
                            <option value="">Year</option>
                            <?php for($i=2013;$i<=2024;$i++) { ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="one_row pay_credit_card">
                          <label for="pay_cc_cvv">Security Code <em>*</em></label>
                          <input type="text" name="pay_cc_cvv" id="pay_cc_cvv"/>
                        </div>    

                        <div class="one_row pay_paypal" style="display:none">
                          <label for="pay_paypal_email">Paypal Email <em>*</em></label>
                          <input type="text" name="pay_paypal_email" id="pay_paypal_email" />
                        </div>
                        <div class="one_row pay_check" style="display:none">
                          <label for="pay_check_number">Check#</label>
                          <input type="text" name="pay_check_number" id="pay_check_number" />
                        </div>
                        <div class="one_row pay_check" style="display:none">
                          <label for="pay_check_date">Date <em>*</em></label>
                          <input type="text" name="pay_check_date" id="pay_check_date"/>
                        </div>
                        <div class="one_row pay_check" style="display:none">
                          <label>&nbsp;</label>
                          <input type="radio" name="pay_check_date_type" value="received" checked />Received&emsp;
                          <input type="radio" name="pay_check_date_type" value="deposited"/>Deposited&emsp;
                          <input type="radio" name="pay_check_date_type" value="refunded"/>Refunded&emsp;
                        </div>
                        <div class="one_row pay_check" style="display:none">
                          <label for="pay_check_deposit_account">Deposit Account</label>
                          <input type="text" name="pay_check_deposit_account" id="pay_check_deposit_account" />
                        </div>
                        <div class="one_row pay_cash" style="display:none">
                          <label for="pay_cash_date">Date <em>*</em></label>
                          <input type="text" name="pay_cash_date" id="pay_cash_date"/>
                        </div>
                        <div class="one_row pay_cash" style="display:none">
                          <label>&nbsp;</label>
                          <input type="radio" name="pay_cash_date_type" value="received" checked />Received&emsp;
                          <input type="radio" name="pay_cash_date_type" value="deposited"/>Deposited&emsp;
                          <input type="radio" name="pay_cash_date_type" value="refunded"/>Refunded&emsp;
                        </div>
                        <div class="one_row pay_cash" style="display:none">
                          <label for="pay_cash_deposit_account">Deposit Account</label>
                          <input type="text" name="pay_cash_deposit_account" id="pay_cash_deposit_account" />
                        </div>
                        <div class="one_row pay_wire" style="display:none">
                          <label for="pay_wire_transfer_date">Transfer Date<em>*</em></label>
                          <input type="text" name="pay_wire_transfer_date" id="pay_wire_transfer_date"/>
                        </div>
                        <div class="one_row pay_bank" style="display:none">
                          <label for="pay_bank_deposit_date">Deposit Date<em>*</em></label>
                          <input type="text" name="pay_bank_deposit_date" id="pay_bank_deposit_date"/>
                        </div>
                        <div class="one_row pay_bank" style="display:none">
                          <label for="pay_bank_deposit_account">Deposit Account</label>
                          <input type="text" name="pay_bank_deposit_account" id="pay_bank_deposit_account" />
                        </div>
                        <div class="one_row pay_other" style="display:none">
                          <label for="pay_other_payment_type_name">Payment Type Name</label>
                          <input type="text" name="pay_other_payment_type_name" id="pay_other_payment_type_name" />
                        </div>


                        <div class="one_row pay_credit_card pay_paypal pay_wire pay_bank pay_other" style="display:block;">
                          <label>&nbsp;</label>
                          <input type="radio" name="pay_option" value="received" checked /> Received&emsp;
                          <input type="radio" name="pay_option" value="refunded" /> Refunded
                        </div>
                        <div class="one_row">
                          <label for="chk_not_balance">&nbsp;</label>
                          <input type="checkbox" name="chk_not_balance" id="chk_not_balance" value="1" /> Does Not Affect Balance
                        </div>
                        <div class="one_row pay_credit_card">
                          <label for="pay_cc_save">&nbsp;</label>
                          <input type="checkbox" name="pay_cc_save" id="pay_cc_save" value="1" /> Save Card Info
                        </div>
                        <div class="one_row" style="height:74px;line-height:50px;">
                          <label for="pay_note" style="line-height:60px;display:block;float:left;">Note</label>
                          <textarea name="pay_note" id="pay_note" style="width:58%;height:60px;resize:none;"></textarea>
                          <div class="clear"></div>
                        </div>
                        <div class="one_row">
                          <label for="btn_pay_receive">&nbsp;</label>
                          <a href="javascript:void(0);" id="btn_pay_receive">Receive Payment</a>
                        </div>
                    </div>
                  </form>
                </div>
              </td>

              <td>    
                <div class="contentareanoscrollstyle v13-grid">
                  <table id="payment_log_table" class="rounded-corner rounded-table table-standard" cellspacing=0 cellpadding=0>
                      <thead>
                        <tr class="title underlined">
                          <td>Payment Date</td>
                          <td>Payment Type</td>
                          <td style="width: 65px;">Affects Balance</td>
                          <td>Detail</td>
                          <td>Payment Amount</td>
                          <td>Balance Due</td>
                          <td>&nbsp;</td>
                        </tr>                       
                      </thead>
                      <tbody id="order_payment">
                      <!-- Adding to javascript(line to 1067) -->
                      <?php echo $accordion_payments; ?>
                      </tbody>
                  </table>
                </div>
              </td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="floatsave" class="v13-savebar wrapper_fixed" style="visibility: hidden;"></div>
  <script type="text/javascript"><!--
    $('.date').datetimepicker({
    	pickTime: false
    });

    $('.datetime').datetimepicker({
    	pickDate: true,
    	pickTime: true
    });

    $('.time').datetimepicker({
    	pickDate: false
    });
  //--></script>

  <script type="text/javascript">
    var ShowSave = function() {
      $('#floatsave').css('visibility', 'visible');
    }

    var saveOrder = function() {
      if(!confirm("Are you sure?")) return;
      $('#order_form').submit();
    }

    jQuery(document).ready(function ($) {
      $('.a65chromecontent').css('display','none');
      $('#a65chromeheader_1').click(function(){                                        
        if($('#arrow_link_1').hasClass('rotate_arrow')) $('#arrow_link_1').removeClass('rotate_arrow');
        else $('#arrow_link_1').addClass('rotate_arrow');      
        $('.a65chromecontent').slideToggle(300);
        $('html, body').animate({ scrollTop: $(this).offset().top }, 'slow');
      });

      $('select[id="pay_type"]').on('change',function(){
        var now_val = $(this).val();
         $('option',$(this)).each(function(){
          var old_val = $(this).attr('value');
          if(now_val != old_val){
            $('#PaymentsAndCredits .new_record .pay_'+ old_val +'').css('display','none');
          }
          $('#PaymentsAndCredits .new_record .pay_'+ now_val +'').css('display','block');
         });
      });
         
      $('#form_payment_new').on('focus', '#pay_cash_date', function(){
          $('#pay_cash_date').datepicker({dateFormat: 'mm-dd-yy'});  console.log('Datepicker');
      });             
      $('#form_payment_new').on('focus', '#pay_check_date', function(){
          $('#pay_check_date').datepicker({dateFormat: 'mm-dd-yy'});  console.log('Datepicker');
      });
      $('#form_payment_new').on('focus', '#pay_wire_transfer_date', function(){
          $('#pay_wire_transfer_date').datepicker({dateFormat: 'mm-dd-yy'});  console.log('Datepicker');
      });
      $('#form_payment_new').on('focus', '#pay_bank_deposit_date', function(){
          $('#pay_bank_deposit_date').datepicker({dateFormat: 'mm-dd-yy'});  console.log('Datepicker');
      });    

      /* When Receive Payment Button click, Submit Payments Data.*/
      function checkNum(num){
       if(num == ""){
        return false;
       }
       var isNum = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
       return isNum.test(num);
      }
      function checkEmail(mail)
      {
       if(mail == ""){
        return false;
       }
       var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)+$/;
       return pattern.test(mail);
      }
      function checkDate(varDate) {
       if(varDate == ""){
        return false;
       }
       
       var checkDate = /^[_0-9-]{1,2}\/[_0-9-]{1,2}\/[_0-9-]{4}$/;
       var checkDate1 = /^[_0-9-]{1,2}\-[_0-9-]{1,2}\-[_0-9-]{4}$/;
       return checkDate.test(varDate) || checkDate1.test(varDate);
      }

      $('#btn_pay_receive').click(function(){
        var pay_type = $('#pay_type').val();

        if(!checkNum($('#pay_amount').val())){
          alert("Please enter correct pay amount");
          $('#pay_amount').focus().select();
          return false;
        }

        if(pay_type == 'credit_card'){
          if(!checkNum($('#pay_cc_number').val())) {
            alert("Please enter correct card number");
            $('#pay_cc_number').focus().select();
            return false;
          }
          if($('#pay_cc_name').val() == "") {
            alert("Please enter name on card");
            $('#pay_cc_name').focus().select();
            return false;
          }
          if($('#pay_exp_month').val() == "") {
            alert("Please select expiration month");
            $('#pay_exp_month').trigger('click');
            return false;
          }
          if($('#pay_exp_year').val() == "") {
            alert("Please select expiration year");
            $('#pay_exp_year').trigger('click');
            return false;
          }
          if(!checkNum($('#pay_cc_cvv').val()) || $('#pay_cc_cvv').val().length != 4) {
            alert("Please enter correct security code");
            $('#pay_cc_cvv').focus().select();
            return false;
          }
        }else if(pay_type == "paypal") {
          if(!checkEmail($('#pay_paypal_email').val())) {
              alert("Please enter correct paypal email address");
              $('#pay_paypal_email').focus().select();
              return false;
          }
        }
        else if(pay_type == "check") {
          /*if(!checkNum($('#pay_check_number').val())) {
            alert("Please enter correct check #");
            $('#pay_check_number').focus().select();
            return false;
          }*/
          if(!checkDate($('#pay_check_date').val())) {
            alert("Please enter correct date");
            $('#pay_check_date').focus();
            return false;
          }
        }
        else if(pay_type == "cash") {
          if(!checkDate($('#pay_cash_date').val())) {
            alert("Please enter correct date");
            $('#pay_cash_date').focus();
            return false;
          }
        }
        else if(pay_type == "wire") {
          if(!checkDate($('#pay_wire_transfer_date').val())) {
            alert("Please enter correct transfer date");
            $('#pay_wire_transfer_date').focus();
            return false;
          }
        }
        else if(pay_type == "bank") {
            if(!checkDate($('#pay_bank_deposit_date').val())) {
            alert("Please enter correct deposit date");
            $('#pay_bank_deposit_date').focus();
            return false;
          }
        }     

        $.ajax({
          url: 'index.php?route=sale/order_volusion/addOrderPayment&token=<?php echo $token; ?>',
          type: 'POST',
          data: $('#form_payment_new').serialize()+'&order_id=<?php echo $order_id; ?>',
          dataType: 'json',
          success: function(html) {
            $('#order_payment').html(html.orderHtml);
            var pay_type = $('#pay_type').val();          
            $('#form_payment_new')[0].reset();
            $('#pay_type').val(pay_type); 
            $('#sel_credit_card').html(html.savedCcHtml);
          },
          error: function(xhr,j,i) { console.log(xhr,j,i);
            alert(i);
          }
        });      
      }); 
   
      $('.a65chromecontent').on('click','.remove_payment_record',function(e){
        var remove_btn = $(this);
        if(!confirm("Are you sure?")) return false;

        $.ajax({
          url: 'index.php?route=sale/order_volusion/delOrderPayment&token=<?php echo $token; ?>',
          type: 'POST',
          data: {'order_payment_id': $(this).attr('data-role')},
          success: function(res) {
            remove_btn.parent().parent().next().css('display','none');
            remove_btn.parent().parent().css('display','none');
          },
          error: function(res,j,i) { console.log(res,j,i);
            alert(i);
          }
        });
      });
    });
  </script>
</div>
<?php echo $footer; ?>
