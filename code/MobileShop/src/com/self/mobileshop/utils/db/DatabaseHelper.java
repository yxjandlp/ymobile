package com.self.mobileshop.utils.db;

import java.io.IOException;

import android.content.Context;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class DatabaseHelper extends SQLiteOpenHelper {
	private static String DB_PATH = "/data/data/com.self.mobileshop/databases/";
	private static final String DB_NAME    =  "user";
	private DatabaseHelper myDBHelper;
	private SQLiteDatabase myDB;

	private final Context myContext;

	public DatabaseHelper(Context context) {
		super(context, DB_NAME, null, 1);
		this.myContext = context;
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
	}

	public void createDatabase() throws IOException {
	
	}
	

	public DatabaseHelper open() throws SQLException {
		myDBHelper = new DatabaseHelper(myContext);
		myDB = myDBHelper.getWritableDatabase();
		return this;
	}
}