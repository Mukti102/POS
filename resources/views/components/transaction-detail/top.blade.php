       <tr class="top">
           <td colspan="6" style="padding: 5px; vertical-align: top">
               <table
                   style="
                            width: 100%;
                            line-height: inherit;
                            text-align: left;
                          ">
                   <tbody>
                       <tr>
                           <td
                               style="
                                  padding: 5px;
                                  vertical-align: top;
                                  text-align: left;
                                  padding-bottom: 20px;
                                ">
                               <font
                                   style="
                                    vertical-align: inherit;
                                    margin-bottom: 25px;
                                  ">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #7367f0;
                                      font-weight: 600;
                                      line-height: 35px;
                                    ">
                                       Customer Info</font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                       {{$transaction->costumer->name}}</font>
                               </font><br />
                           
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                       {{$transaction->costumer->phone}}</font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                         {{$transaction->costumer->address}}</font>
                               </font><br />
                           </td>
                  
                           <td
                               style="
                                  padding: 5px;
                                  vertical-align: top;
                                  text-align: left;
                                  padding-bottom: 20px;
                                ">
                               <font
                                   style="
                                    vertical-align: inherit;
                                    margin-bottom: 25px;
                                  ">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #7367f0;
                                      font-weight: 600;
                                      line-height: 35px;
                                    ">
                                       Invoice Info</font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                       Reference
                                   </font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                       Payment Status</font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                       Status</font>
                               </font><br />
                           </td>
                           <td
                               style="
                                  padding: 5px;
                                  vertical-align: top;
                                  text-align: right;
                                  padding-bottom: 20px;
                                ">
                               <font
                                   style="
                                    vertical-align: inherit;
                                    margin-bottom: 25px;
                                  ">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #7367f0;
                                      font-weight: 600;
                                      line-height: 35px;
                                    ">
                                       &nbsp;</font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #000;
                                      font-weight: 400;
                                    ">
                                         {{$transaction->reference}}
                                   </font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                    class="text-capitalize"
                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #2e7d32;
                                      font-weight: 400;
                                    ">
                                         {{$transaction->status_payment}}</font>
                               </font><br />
                               <font style="vertical-align: inherit">
                                   <font
                                    class="text-capitalize"

                                       style="
                                      vertical-align: inherit;
                                      font-size: 14px;
                                      color: #2e7d32;
                                      font-weight: 400;
                                    ">
                                         {{$transaction->status}}</font>
                               </font><br />
                           </td>
                       </tr>
                   </tbody>
               </table>
           </td>
       </tr>
