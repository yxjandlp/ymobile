package com.test;

import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import com.self.mobileshop.R;

import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;

public class Test extends Activity {
	
	private static String urlString = "http://s342777908.gotoip4.com/api.php?r=shop/getall";
	
	private TextView textView;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_test);
		textView = (TextView)this.findViewById(R.id.testTextView);
		JSONObject jsonObject = doGet(urlString);
		Log.i("json object to string", jsonObject.toString());
		textView.setText(jsonObject.toString());
	}
	
	public static JSONObject doGet(String url) {
		try {
			String result = null;
			DefaultHttpClient httpClient = new DefaultHttpClient();
			
			HttpGet request = new HttpGet(url);
			HttpResponse response = httpClient.execute(request);
			result = EntityUtils.toString(response.getEntity());
			JSONObject object = new JSONObject(result);
			
			Log.i("response json string:", result);
			return object;
		} catch (Exception e) {
			// TODO: handle exception
			e.printStackTrace();
		}
		return null;
	}
	
}
