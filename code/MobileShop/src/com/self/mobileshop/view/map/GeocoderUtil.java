package com.self.mobileshop.view.map;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Locale;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.location.Address;
import android.util.Log;

public class GeocoderUtil {
	private final static String TAG = "GeocoderUtil";
	private final static String STATUS = "status";
	private final static String STATUS_OK = "OK";
	private final static String RESULTS = "results";
	private final static String RESULTS_TYPES = "types";
	private final static String RESULTS_TYPES_COUNTRY = "country";
	private final static String RESULTS_TYPES_LOCALITY = "locality";
	private final static String RESULTS_TYPES_SUBLOCALITY = "sublocality";
	private final static String RESULTS_TYPES_ADMINAREA_LEVEL1 = "administrative_area_level_1";
	private final static String RESULTS_TYPES_ADMINAREA_LEVEL2 = "administrative_area_level_2";

	private final static String RESULTS_FORMATTED_ADDRESS = "formatted_address";
	private final static String RESULTS_ADDRESS_COMPONENTS = "address_components";
	private final static String RESULTS_ADDRESS_COMPONENTS_LONGNAME = "long_name";
	private final static String RESULTS_GEOMETRY = "geometry";
	private final static String RESULTS_GEOMETRY_LOCATION = "location";
	private final static String RESULTS_GEOMETRY_LOCATION_LAT = "lat";
	private final static String RESULTS_GEOMETRY_LOCATION_LNG = "lng";

	public static Address getLocationInfo(String address) {
		StringBuilder sb = new StringBuilder();
		BufferedReader br = null;
		try {
			HttpGet httpGet = new HttpGet("https://maps.googleapis.com/maps/api/geocode/json?address=" + URLEncoder.encode(address, "UTF-8") + "&language=zh-CN&sensor=true");

			HttpResponse response = new DefaultHttpClient().execute(httpGet);
			HttpEntity entity = response.getEntity();
			InputStream stream = entity.getContent();
			br = new BufferedReader(new InputStreamReader(stream, "UTF-8"));
			String line;
			while ((line = br.readLine()) != null) {
				sb.append(line);
			}
			JSONObject jsonObj = new JSONObject(sb.toString());
			Log.d(TAG, jsonObj.toString());
			if (STATUS_OK.equals(jsonObj.getString(STATUS))) {
				JSONObject jsonAddress = jsonObj.getJSONArray(RESULTS).getJSONObject(0);
				return JsonToAddress(jsonAddress);
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}

	public static Address getAddress(double longitude, double latitude) {
		StringBuilder sb = new StringBuilder();
		BufferedReader br = null;
		try {
			HttpGet httpGet = new HttpGet("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + latitude + "," + longitude + "&oe=utf-8&language=zh-CN&sensor=true");
			HttpResponse response = new DefaultHttpClient().execute(httpGet);
			HttpEntity entity = response.getEntity();
			InputStream stream = entity.getContent();
			br = new BufferedReader(new InputStreamReader(stream, "UTF-8"));
			String line;
			while ((line = br.readLine()) != null) {
				sb.append(line);
			}
			JSONObject jsonObj = new JSONObject(sb.toString());
			Log.d(TAG, jsonObj.toString());
			if (STATUS_OK.equals(jsonObj.getString(STATUS))) {
				JSONObject jsonAddress = jsonObj.getJSONArray(RESULTS).getJSONObject(0);
				return JsonToAddress(jsonAddress);
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}

	private static Address JsonToAddress(JSONObject jsonAddress) throws JSONException, UnsupportedEncodingException {
		Address address = null;
		Log.d(TAG, "jsonAddress -> " + jsonAddress);
		if (jsonAddress != null) {
			address = new Address(Locale.CHINA);
			String formattedAddress = jsonAddress.getString(RESULTS_FORMATTED_ADDRESS);
			String[] addressLine = formattedAddress.split(",");
			Log.d(TAG, "formattedAddress -> " + formattedAddress + "  ,addressLine.length -> " + addressLine.length);
			for (int i = 0; i < addressLine.length; i++) {
				address.setAddressLine(i, addressLine[i]);
			}
			JSONObject location = jsonAddress.getJSONObject(RESULTS_GEOMETRY).getJSONObject(RESULTS_GEOMETRY_LOCATION);
			address.setLatitude(location.getDouble(RESULTS_GEOMETRY_LOCATION_LAT));
			address.setLongitude(location.getDouble(RESULTS_GEOMETRY_LOCATION_LNG));
			Log.d(TAG, "location -> " + location);
			JSONArray jsonAddressComponents = jsonAddress.getJSONArray(RESULTS_ADDRESS_COMPONENTS);
			Log.d(TAG, "jsonAddressComponents -> " + jsonAddressComponents);
			for (int i = 0; i < jsonAddressComponents.length(); i++) {
				JSONObject jsonAddressComp = jsonAddressComponents.getJSONObject(i);
				// String longName = jsonAddressComp.getString(RESULTS_ADDRESS_COMPONENTS_LONGNAME);
				String longName = new String(jsonAddressComp.getString(RESULTS_ADDRESS_COMPONENTS_LONGNAME).getBytes("ISO8859-1"), "UTF-8");
				JSONArray jsonTypesArray = jsonAddressComp.optJSONArray(RESULTS_TYPES);
				if (jsonTypesArray != null) {
					for (int j = 0; j < jsonTypesArray.length(); j++) {
						String str = jsonTypesArray.getString(j);
						Log.d(TAG, "jsonTypesArray -> " + j + " " + str + " longname-> " + longName);
						if (RESULTS_TYPES_LOCALITY.equals(str)) {
							address.setLocality(longName);
						} else if (RESULTS_TYPES_SUBLOCALITY.equals(str)) {
							address.setSubLocality(longName);
						} else if (RESULTS_TYPES_ADMINAREA_LEVEL1.equals(str)) {
							address.setAdminArea(longName);
						} else if (RESULTS_TYPES_ADMINAREA_LEVEL2.equals(str)) {
							address.setSubAdminArea(longName);
						} else if (RESULTS_TYPES_COUNTRY.equals(str)) {
							address.setCountryName(longName);
						}
					}
				} else {
					String str = jsonAddressComp.getString(RESULTS_TYPES);
					if (RESULTS_TYPES_LOCALITY.equals(str)) {
						address.setLocality(longName);
					} else if (RESULTS_TYPES_SUBLOCALITY.equals(str)) {
						address.setSubLocality(longName);
					} else if (RESULTS_TYPES_ADMINAREA_LEVEL1.equals(str)) {
						address.setAdminArea(longName);
					} else if (RESULTS_TYPES_ADMINAREA_LEVEL2.equals(str)) {
						address.setSubAdminArea(longName);
					} else if (RESULTS_TYPES_COUNTRY.equals(str)) {
						address.setCountryName(longName);
					}
				}
			}
		}
		return address;
	}
}
