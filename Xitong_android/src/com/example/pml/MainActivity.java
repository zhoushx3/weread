package com.example.pml;

import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.database.sqlite.SQLiteDatabase;
import android.os.Build;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MenuItem.OnMenuItemClickListener;
import android.view.View;
import android.view.View.OnClickListener;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebSettings.LayoutAlgorithm;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

public class MainActivity extends Activity{
	private final static int SCAN_BACK_CODE = 1;
	
	private Context context;
	private WebView webView;
	private WebSettings webSettings;
	private WebViewClient webViewClient;
	private ProgressBar progressBar;
	private String curTitle;
	
	@SuppressLint("NewApi") @Override
	protected void onCreate(Bundle sis) {
		super.onCreate(sis);
		setContentView(R.layout.activity_main);
		context = this;
		
		progressBar = (ProgressBar)findViewById(R.id.progress_bar);
		webView = (WebView)findViewById(R.id.web_view);
		webSettings = webView.getSettings();
		webViewClient = new WebViewClient();
		webSettings.setDefaultTextEncodingName("UTF-8");
		webSettings.setJavaScriptEnabled(true);
		webSettings.setLoadWithOverviewMode(true);
		webSettings.setLayoutAlgorithm(LayoutAlgorithm.NORMAL);
		
		webSettings.setJavaScriptEnabled(true);
		webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
		webSettings.setAllowFileAccess(true);// 设置允许访问文件数据
		webSettings.setSupportZoom(true);
		webSettings.setBuiltInZoomControls(true);
		webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
		webSettings.setCacheMode(WebSettings.LOAD_CACHE_ELSE_NETWORK);
		webSettings.setDomStorageEnabled(true);
		webSettings.setDatabaseEnabled(true);
		
		webView.setWebViewClient(webViewClient);
		webView.setWebChromeClient(new WebChromeClient() {
	          @Override
	          public void onProgressChanged(WebView view, int newProgress) {
	              if (newProgress == 100) {
	                  progressBar.setVisibility(View.INVISIBLE);
	              } else {
	                  if (View.INVISIBLE == progressBar.getVisibility()) {
	                      progressBar.setVisibility(View.VISIBLE);
	                  }
	                  progressBar.setProgress(newProgress);
	              }
	              super.onProgressChanged(view, newProgress);
	          }
	          
	          
	          @Override
	            public void onReceivedTitle(WebView view, String title) {
	                super.onReceivedTitle(view, title);
	                curTitle = title;
	            }
	      });
		Bundle bundle = this.getIntent().getExtras();
		//String url = "http://172.18.32.225/Xitong/index.php/Books/allBooks.html";
		String url = "https://www.baidu.com/";
		if (bundle != null) {
			url = bundle.getString("url");
		}
		webView.loadUrl(url);
	}
	
	
	@TargetApi(Build.VERSION_CODES.HONEYCOMB) @SuppressLint("NewApi") @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        super.onCreateOptionsMenu(menu);
        //添加菜单项
        MenuItem add = menu.add(0,0,0,"添加收藏");
        MenuItem scan = menu.add(0,0,0,"扫一扫");
        MenuItem collect = menu.add(0,0,0,"我的收藏");
        //MenuItem reload = menu.add(0,0,0,"s")
        //绑定到ActionBar 
        add.setShowAsAction(MenuItem.SHOW_AS_ACTION_IF_ROOM);
        scan.setShowAsAction(MenuItem.SHOW_AS_ACTION_IF_ROOM);
        collect.setShowAsAction(MenuItem.SHOW_AS_ACTION_IF_ROOM);
        
        add.setOnMenuItemClickListener(new OnMenuItemClickListener() {
			@Override
			public boolean onMenuItemClick(MenuItem arg0) {
				// TODO Auto-generated method stub
				
				String url = webView.getUrl();
				SQLiteDatabase db = openOrCreateDatabase("pmlDataBase.db", context.MODE_PRIVATE, null);
				db.execSQL("CREATE TABLE IF NOT EXISTS records (_id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR, url VARCHAR)");
				ContentValues cv = new ContentValues();
				//cv.put("isDone", 0);//能修改或者新建的都是未完成
				cv.put("name", curTitle);
				cv.put("url", url);
				db.insert("records", null, cv);
				db.close();
				
				Toast toast = Toast.makeText(getApplicationContext(), "收藏成功", Toast.LENGTH_SHORT);
				toast.show();
				
				return false;
			}
		});
        
        scan.setOnMenuItemClickListener(new OnMenuItemClickListener() {
			@Override
			public boolean onMenuItemClick(MenuItem arg0) {
				// TODO Auto-generated method stub
				Intent intent = new Intent();
				intent.setClass(MainActivity.this, MipcaActivityCapture.class);
				intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivityForResult(intent, SCAN_BACK_CODE);
				return false;
			}

			
		});
        
        collect.setOnMenuItemClickListener(new OnMenuItemClickListener() {

			@Override
			public boolean onMenuItemClick(MenuItem arg0) {
				// TODO Auto-generated method stub
				Intent intent = new Intent();
				intent.setClass(MainActivity.this, SecondActivity.class);
				startActivity(intent);
				return false;
			}
        	
        });
        
        
        return true;
    }
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		switch (requestCode) {
			case SCAN_BACK_CODE:
				if (resultCode == RESULT_OK) {
					Bundle bundle = data.getExtras();
					String s = bundle.getString("result");
					webView.loadUrl(s);
				}
				break;
		}
	}
	
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (keyCode == KeyEvent.KEYCODE_BACK) {
			 webView.goBack(); // goBack()表示返回WebView的上一页面
	         return true;
		}
		return super.onKeyDown(keyCode,event);	
	}
}







