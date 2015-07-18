package com.example.pml;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.SurfaceHolder;
import android.view.View;
import android.view.MenuItem.OnMenuItemClickListener;
import android.view.SurfaceHolder.Callback;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemLongClickListener;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;
import android.widget.Toast;

public class SecondActivity extends Activity{
	private ListView listView;
	Map<String, String> map;
	Map<Integer, Integer> delMap;
	List<String> data;
	Context context;
	ArrayAdapter<String> arrayAdapter;
	List<Map<String, Object>> mDataList;
	
	@Override
	public void onCreate(Bundle sis) {
		super.onCreate(sis);
		setContentView(R.layout.activity_second);
		context = this;
		//listView = new ListView(this);
		//arrayAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, getData());
		getData();
		final SimpleAdapter mSimpleAdapter = new SimpleAdapter(this,
    			mDataList,
    			R.layout.list_item,
    			new String[]{"id", "name", "url"},
    			new int[]{R.id.textView0, R.id.textView1, R.id.textView2}); 
		
		listView = (ListView)findViewById(R.id.listView0);  
		listView.setAdapter(mSimpleAdapter);
		
		listView.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
					long arg3) {
				// TODO Auto-generated method stub
				String url = ((TextView)arg1.findViewById(R.id.textView2)).getText().toString();
				//String url = map.get(id);
				Intent intent = new Intent();
				Bundle bundle = new Bundle();
				bundle.putString("url", url);
				intent.putExtras(bundle);
				intent.setClass(context, MainActivity.class);
				startActivity(intent);
				((Activity) context).finish();
				
			}
			
		});
		
		listView.setOnItemLongClickListener(new OnItemLongClickListener() {

			@Override
			public boolean onItemLongClick(AdapterView<?> arg0, View arg1,
					int arg2, long arg3) {
				// TODO Auto-generated method stub
				//data.remove(arg2);
				//String id = ((TextView)arg1.findViewById(android.R.id.text1)).getText().toString();
				//map.remove(id);
				//arrayAdapter.notifyDataSetChanged();
				//Toast toast = Toast.makeText(getApplicationContext(), id, Toast.LENGTH_SHORT);
				//toast.show();
				
				SQLiteDatabase db = openOrCreateDatabase("pmlDataBase.db", context.MODE_PRIVATE, null);
				//db.execSQL("DELETE * FROM records WHERE name=" + id);
				//db.close();
				String s1 = "_id=?";
				String t = ((TextView)arg1.findViewById(R.id.textView0)).getText().toString();
				String[] ss = new String[]{t};
				db.delete("records", s1, ss);
				db.close();
				
				mDataList.remove(arg2);
				mSimpleAdapter.notifyDataSetChanged();
				
				return true;
			}
			
		});
	}
	

	private void getData() {
		//data = new ArrayList<String>();
		//map =  new HashMap<String,String>();
		mDataList = new ArrayList<Map<String, Object>>();
		SQLiteDatabase db = openOrCreateDatabase("pmlDataBase.db", context.MODE_PRIVATE, null);
		db.execSQL("CREATE TABLE IF NOT EXISTS records (_id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR, url VARCHAR)");
		Cursor c = db.rawQuery("SELECT * FROM records", null);
		while (c != null && c.moveToNext()) {
			int id = c.getInt(c.getColumnIndex("_id"));
			String name = c.getString(c.getColumnIndex("name"));
			String url = c.getString(c.getColumnIndex("url"));
			Map<String, Object> item = new HashMap<String, Object>();
			item.put("id", String.valueOf(id));
			item.put("name", name);
			item.put("url", url);
			mDataList.add(item);
			/*
			data.add(name);
			map.put(name, url);
			delMap.put(arg0, arg1)
			*/
		}
		db.close();
		
		//return data;
	}
	
	@SuppressLint("NewApi") public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        super.onCreateOptionsMenu(menu);
        //添加菜单项
        MenuItem back = menu.add(0,0,0,"返回");
        //绑定到ActionBar 
        back.setShowAsAction(MenuItem.SHOW_AS_ACTION_IF_ROOM);
        
        back.setOnMenuItemClickListener(new OnMenuItemClickListener() {
			@Override
			public boolean onMenuItemClick(MenuItem arg0) {
				// TODO Auto-generated method stub
				((Activity) context).finish();
				return false;
			}

			
		});
        return true;
    }

}






