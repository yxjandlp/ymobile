package com.self.mobileshop.utils.db;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import android.content.Context;
import android.content.SharedPreferences;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;

public class DBUtils {
	private static String DB_PATH = "/data/data/com.self.mobileshop/databases/";
	private static final String DB_NAME  = "city";
	private static final String ASSETS_NAME    = "city";

	// 检查数据库是否有效
	public static boolean checkDataBase() {
		SQLiteDatabase checkDB = null;
		String myPath = DB_PATH + DB_NAME;
		try {
			checkDB = SQLiteDatabase.openDatabase(myPath, null,
					SQLiteDatabase.OPEN_READONLY);
		} catch (SQLiteException e) {
			// database does't exist yet.
		}
		if (checkDB != null) {
			checkDB.close();
		}
		return checkDB != null ? true : false;
	}

	public static void createDataBase(Context mContext) throws IOException {
		boolean dbExist = checkDataBase();
		if (dbExist) {
			// 数据库已存在
		} else {
			// 创建数据库
			try {
				File dir = new File(DB_PATH);
				if (!dir.exists()) {
					dir.mkdirs();
				}
				File dbf = new File(DB_PATH + DB_NAME);
				if (dbf.exists()) {
					dbf.delete();
				}
				SQLiteDatabase.openOrCreateDatabase(dbf, null);
				// 复制asseets中的db文件到DB_PATH下
				copyDataBase(mContext);
			} catch (IOException e) {
				throw new Error("数据库创建失败");
			}
		}
	}

	public static void copyDataBase(Context mContext) throws IOException {
		InputStream myInput = mContext.getAssets().open(ASSETS_NAME);
		String outFileName = DB_PATH + DB_NAME;
		OutputStream myOutput = new FileOutputStream(outFileName);
		byte[] buffer = new byte[1024];
		int length;
		while ((length = myInput.read(buffer)) > 0) {
			myOutput.write(buffer, 0, length);
		}
		myOutput.flush();
		myOutput.close();
		myInput.close();
	}
	
	public static void putAssertSharedpref(Context mContext){
		SharedPreferences preferences = mContext.getSharedPreferences("citySet", Context.MODE_PRIVATE);
		SharedPreferences.Editor editor = preferences.edit();
		editor.putBoolean("hasSetCity", true);
		editor.commit();
	}
	
	
}
