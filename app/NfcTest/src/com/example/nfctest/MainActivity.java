package com.example.nfctest;

import android.os.Bundle;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.view.Menu;
import java.sql.Date;
import android.content.Intent;
import android.nfc.FormatException;
import android.nfc.NdefRecord;
import android.nfc.NfcAdapter;
import android.nfc.NdefMessage;
import android.os.Bundle;
import android.os.Parcelable;
import android.widget.EditText;
import android.widget.Toast;

@SuppressLint("NewApi")
public class MainActivity extends Activity {
	EditText input;
	EditText output;
	NfcAdapter mAdapter;
	NdefMessage msgs[];
	NdefRecord msg;
	NfcAdapter nfcAdapter;
	boolean somethingHappened = false;
	double initialTime;

	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) 
	{
		super.onCreate(savedInstanceState);
	    setContentView(R.layout.activity_main);
	    input = (EditText) findViewById(R.id.editText1);
	    output = (EditText) findViewById(R.id.editText2);
	    nfcAdapter = NfcAdapter.getDefaultAdapter(this);
	    if (nfcAdapter == null)
	    {
	        Toast.makeText(this, "No NFC.  Sucks to suck.", Toast.LENGTH_LONG).show();
	        System.out.println("No NFC.  Sucks to suck.");
	        return;
	    }
	    initialTime =  new Date(0).getTime();
	    while(!somethingHappened)
	    {
	        if(30000 < new Date(0).getTime() - initialTime)
	            somethingHappened = true;
	        onResume();
	    }
	}

	@SuppressLint("NewApi")
	public void onResume() 
	{
	    super.onResume();
	    msg = new NdefRecord(NdefRecord.TNF_ABSOLUTE_URI, "text/plain".getBytes(), 
	            new byte[0], input.getText().toString().getBytes());
	    input.setText("");
	    if (NfcAdapter.ACTION_NDEF_DISCOVERED.equals(getIntent().getAction())) {
	        Intent intent = getIntent();
	        Parcelable[] rawMsgs = intent.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
	        if (rawMsgs != null) {
	            somethingHappened = true;
	            msgs = new NdefMessage[rawMsgs.length];
	            for (int i = 0; i < rawMsgs.length; i++) {
	                msgs[i] = (NdefMessage) rawMsgs[i];
	                output.append(msgs[i].toString());
	            }
	        }           
	    }
	    //process the msgs array
	    NdefRecord send[] = {msg};
	    try{
	        nfcAdapter.setNdefPushMessage(new NdefMessage(send), this);
	        somethingHappened = true;
	    }catch(Exception e){}
	}

}
