package com.example.sportsclub.activities;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.example.sportsclub.Constants;
import com.example.sportsclub.R;
import com.example.sportsclub.adapters.BookingAdapter;
import com.example.sportsclub.model.Booking;
import com.facebook.shimmer.ShimmerFrameLayout;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import butterknife.BindView;
import butterknife.ButterKnife;

import static com.example.sportsclub.activities.SignInActivity.ID;
import static com.example.sportsclub.activities.SignInActivity.SHARED_PREFS;
import static xdroid.toaster.Toaster.toast;

public class HistoryBookingActivity extends AppCompatActivity {
    @BindView(R.id.toolbar)
    Toolbar toolbar;
    @BindView(R.id.toolbar_title)
    TextView mTitle;
    @BindView(R.id.rv_booking)
    RecyclerView rvBooking;
    @BindView(R.id.shimmer_view_container)
    ShimmerFrameLayout mShimmerViewContainer;
    @BindView(R.id.tvCondition)
    TextView tvCondition;
    @BindView(R.id.ivReload)
    ImageView ivReload;

    private ArrayList<Booking> list = new ArrayList<>();
    private BookingAdapter bookingAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history_booking);
        ButterKnife.bind(this);

        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        String title = getIntent().getStringExtra("Title");
        mTitle.setText(title);

        SharedPreferences sharedPreferences = getSharedPreferences(SHARED_PREFS, Context.MODE_PRIVATE);
        String id = sharedPreferences.getString(ID, "");

        fetchUserBookings(id);
        ivReload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mShimmerViewContainer.startShimmer();
                mShimmerViewContainer.setVisibility(View.VISIBLE);
                rvBooking.setVisibility(View.GONE);
                tvCondition.setVisibility(View.GONE);
                ivReload.setVisibility(View.GONE);
                fetchUserBookings(id);
            }
        });
        rvBooking.setHasFixedSize(true);
        rvBooking.setLayoutManager(new LinearLayoutManager(this));
    }

    public void showRecyclerList() {
        rvBooking.setLayoutManager(new LinearLayoutManager(this));
        bookingAdapter = new BookingAdapter(list);
        rvBooking.setAdapter(bookingAdapter);
    }

    public void fetchUserBookings(String id) {
        AndroidNetworking.get(Constants.BASE_URL + "/api/bookings/{id}")
                .addPathParameter("id", id)
                .setPriority(Priority.LOW)
                .build()
                .getAsJSONObject(new JSONObjectRequestListener() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            if (bookingAdapter != null) {
                                bookingAdapter.clearData();
                                bookingAdapter.notifyDataSetChanged();
                            }
                            if (list != null)  list.clear();
                            JSONArray data = response.getJSONArray("data");
                            if(data == null) {
                                toast("Tidak ada data");
                                return;
                            }
                            System.out.println("Data : " + data.length());
                            if (data.length() <= 0){
                                tvCondition.setVisibility(View.VISIBLE);
                                tvCondition.setText(Constants.TEXT_LOAD_NOL_BOOKING);
                                ivReload.setVisibility(View.GONE);
                                rvBooking.setVisibility(View.GONE);
                                mShimmerViewContainer.stopShimmer();
                                mShimmerViewContainer.setVisibility(View.GONE);
                            }else{
                            for (int i = 0; i < data.length(); i++) {
                                JSONObject item = data.getJSONObject(i);
                                JSONObject field = item.getJSONObject("field");
                                Booking booking = new Booking();
                                booking.setStatus(item.getString("status"));
                                booking.setDate(item.getString("date"));
                                booking.setField(field.getString("name"));
                                booking.setTotalPrice(item.getString("total_price"));
                                String realTime1 = item.getString("time").replace("[", "");
                                String realTime2 = realTime1.replace("]", "");
                                String realTime3 = realTime2.replace("\"", "");
                                String[] ary = realTime3.split(",");
                                String realTime4 = realTime3.replace(",", " - ");
                                if (ary.length > 1){
                                    realTime4 = ary[0] + " - " + ary[ary.length - 1];
                                }
                                booking.setTime(realTime4);
                                booking.setCode(item.getString("code"));
                                list.add(booking);
                                System.out.println("index cek " + ary[0] + ary[ary.length - 1]);
                            }
                            showRecyclerList();
                                mShimmerViewContainer.stopShimmer();
                                mShimmerViewContainer.setVisibility(View.GONE);
                                rvBooking.setVisibility(View.VISIBLE);
                                tvCondition.setVisibility(View.GONE);
                                ivReload.setVisibility(View.GONE);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }

                    @Override
                    public void onError(ANError anError) {
                        mShimmerViewContainer.stopShimmer();
                        mShimmerViewContainer.setVisibility(View.GONE);
                        rvBooking.setVisibility(View.GONE);
                        tvCondition.setVisibility(View.VISIBLE);
                        tvCondition.setText(Constants.TEXT_GAGAL_MEMUAT);
                        ivReload.setVisibility(View.VISIBLE);
                        Log.d("SCA", "onErrorBody: " + anError.getErrorBody());
                        Log.d("SCA", "onErrorLocalMessage: " + anError.getLocalizedMessage());
                        Log.d("SCA", "onErrorResponse: " + anError.getResponse());
                        Log.d("SCA", "onErrorCode: " + anError.getErrorCode());
                        Log.d("SCA", "onErrorDetail: " + anError.getErrorDetail());
                    }
                });
    }

    public boolean onSupportNavigateUp() {
        finish();
        return true;
    }
}