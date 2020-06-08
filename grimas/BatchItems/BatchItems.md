# BatchItems - Add Item Records to Alma in Batch

This grima helps you add multiple Item Records to Alma at one time.  This grima will also populate the Statistics Note 2 "FIRE 2018 OZONE" and the Statistics Note 3 of the user's choice.  After adding the Item Record you will see a list of generated messages providing you with the barcode of the new record.

## Input
* Holdings Id number for which you want the Item Record associated with.

## Procedure
The first box of the form ask you which Statistics Note 3 phrase you would like populated.  This is a drop-down option that allows you to choose the needed defined phrase:![Screenshot of grima form](images/BatchItems-out0.png)                                                          
The next part of the form is where you will input your Holdings Id number(s).  Input each Holdings Id number on its own line without any spacing:
![Screenshot of grima form](images/BatchItems-out1.png)

After you have chosen the appropriate Statistics Note 3 phrase and provided the Holdings Id number(s), one per line, click the submit button.

When the grima is completed, a list of messages will appear for each Holdings Id number that is provided.  There are two messages.  The first message will look like the following:
![Screenshot of grima form](images/BatchItems-out2.png)

Which means that Alma could not find the Holdings Record because it has been deleted or recently created.

The second message will look like the following:
![Screenshot of grima form](images/BatchItems-out3.png)

This message provides the Holdings Id and the Barcode for the newly created Item Record.

## API requirements
* Bibs - read/write
* Analytics - read/write 
