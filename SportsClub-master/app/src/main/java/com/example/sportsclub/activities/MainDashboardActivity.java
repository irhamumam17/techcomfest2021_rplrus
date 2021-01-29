package com.example.sportsclub.activities;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.bumptech.glide.Glide;
import com.example.sportsclub.Constants;
import com.example.sportsclub.R;
import com.example.sportsclub.adapters.FieldAdapter;
import com.example.sportsclub.model.Field;
import com.facebook.shimmer.ShimmerFrameLayout;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;

import butterknife.BindView;
import butterknife.ButterKnife;
import cn.pedant.SweetAlert.SweetAlertDialog;
import de.hdodenhof.circleimageview.CircleImageView;

import static com.example.sportsclub.activities.SignInActivity.EMAIL;
import static com.example.sportsclub.activities.SignInActivity.NAME;
import static com.example.sportsclub.activities.SignInActivity.SHARED_PREFS;
import static xdroid.toaster.Toaster.toast;

public class MainDashboardActivity extends AppCompatActivity {
    @BindView(R.id.tvDateToday)
    TextView tvDateToday;
    @BindView(R.id.tvResultCategory)
    TextView tvResultCategory;
    @BindView(R.id.tvName)
    TextView tvName;
    @BindView(R.id.tvEmail)
    TextView tvEmail;
    @BindView(R.id.tvCondition)
    TextView tvCondition;
    @BindView(R.id.divAllMatch)
    LinearLayout divAllMatch;
    @BindView(R.id.divMyMatch)
    LinearLayout divMyMatch;
    @BindView(R.id.divBooking)
    LinearLayout divBooking;
    @BindView(R.id.divFutsal)
    LinearLayout divFutsal;
    @BindView(R.id.divBuluTangkis)
    LinearLayout divBuluTangkis;
    @BindView(R.id.divVolley)
    LinearLayout divVolley;
    @BindView(R.id.ivFutsal)
    CircleImageView ivFutsal;
    @BindView(R.id.ivBuluTangkis)
    CircleImageView ivBuluTangkis;
    @BindView(R.id.ivVolley)
    CircleImageView ivVolley;
    @BindView(R.id.ivReload)
    ImageView ivReload;
    @BindView(R.id.divProfile)
    ImageView divProfile;
    @BindView(R.id. shimmer_view_container)
    ShimmerFrameLayout mShimmerViewContainer;
    @BindView(R.id.rv_Fields)
    RecyclerView rv_Fields;

    private String sResultByCategory = "";
    private ArrayList<Field> list = new ArrayList<>();
    private FieldAdapter fieldAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_dashboard);
        ButterKnife.bind(this);
        setValue();

        SharedPreferences sharedPreferences = getSharedPreferences(SHARED_PREFS, MODE_PRIVATE);
        if (!sharedPreferences.getString(NAME, "").isEmpty()){
            tvName.setText(sharedPreferences.getString(NAME, ""));
            tvEmail.setText(sharedPreferences.getString(EMAIL, ""));
        }else {
            tvName.setText("Anda belum login, Silahkan login untuk akses fitur lebih, Klik untuk login");
            divProfile.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    alertNotLogin();
                }
            });
            tvName.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    alertNotLogin();
                }
            });
            divAllMatch.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    alertNotLogin();
                }
            });
            divMyMatch.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    alertNotLogin();
                }
            });
            divBooking.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    alertNotLogin();
                }
            });
        }

        sResultByCategory = Constants.CATEGORY_FUTSAL;
        tvResultCategory.setText(sResultByCategory);

        fetchFields(sResultByCategory);

        ivReload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mShimmerViewContainer.startShimmer();
                mShimmerViewContainer.setVisibility(View.VISIBLE);
                rv_Fields.setVisibility(View.GONE);
                tvCondition.setVisibility(View.GONE);
                ivReload.setVisibility(View.GONE);
                fetchFields(sResultByCategory);
            }
        });

        rv_Fields.setHasFixedSize(true);
        rv_Fields.setLayoutManager(new LinearLayoutManager(this));
        rv_Fields.setNestedScrollingEnabled(false);

    }

    private void alertNotLogin(){
        new SweetAlertDialog(MainDashboardActivity.this, SweetAlertDialog.WARNING_TYPE)
                .setContentText("Anda belum login, Silahkan login untuk akses fitur lebih")
                .setConfirmText("Login")
                .setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                    @Override
                    public void onClick(SweetAlertDialog sDialog) {
                        Intent intent = new Intent(MainDashboardActivity.this, LandingPageActivity.class);
                        startActivity(intent);
                        sDialog.dismissWithAnimation();
                    }
                })
                .setCancelButton("Tidak", new SweetAlertDialog.OnSweetClickListener() {
                    @Override
                    public void onClick(SweetAlertDialog sDialog) {
                        sDialog.dismissWithAnimation();
                    }
                })
                .show();
    }

    private void setValue (){
        tvDateToday.setText(new SimpleDateFormat("EEE, dd-MM-yyyy", Locale.getDefault()).format(new Date()));

        Glide.with(this).load(R.drawable.item_photo2).into(ivFutsal);
        Glide.with(this).load(R.drawable.coming_soon).into(ivBuluTangkis);
        Glide.with(this).load(R.drawable.coming_soon).into(ivVolley);

        divAllMatch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainDashboardActivity.this, AllMatchActivity.class);
                startActivity(intent);
            }
        });
        divMyMatch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainDashboardActivity.this, MyMatchActivity.class);
                startActivity(intent);
            }
        });
        divProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainDashboardActivity.this, ProfileActivity.class);
                intent.putExtra("Title", "Profile");
                startActivity(intent);
            }
        });

        divBooking.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainDashboardActivity.this, HistoryBookingActivity.class);
                intent.putExtra("Title", "Booking");
                startActivity(intent);
            }
        });

        divFutsal.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categoryFutsal(Constants.CATEGORY_FUTSAL);
            }
        });
        divBuluTangkis.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categoryBadminton(Constants.CATEGORY_BADMINTON);
            }
        });
        divVolley.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                categoryVolley(Constants.CATEGORY_VOLLEY);
            }
        });
    }

    private void categoryFutsal (String category){
        sResultByCategory = category;
        tvResultCategory.setText(category);
        fetchFields(category);
    }

    private void categoryVolley (String category){
        toast("Fitur sedang dalam pengembangan");
    }

    private void categoryBadminton (String category){
        toast("Fitur sedang dalam pengembangan");

    }

    private void showRecycler() {
        rv_Fields.setLayoutManager(new LinearLayoutManager(this));
        fieldAdapter = new FieldAdapter(list);
        rv_Fields.setAdapter(fieldAdapter);
        fieldAdapter.setOnItemClickCallback(new FieldAdapter.OnItemClickCallback() {
            @Override
            public void onItemClicked(Field data) {
                showSelectedField(data);
            }
        });
    }

    private void showSelectedField(Field field) {
        Intent intent = new Intent(this, DetailFieldActivity.class);
        intent.putExtra("test", list);
        intent.putExtra("Item Data", field);
        startActivity(intent);
    }

    public void fetchFields(String category) {
        AndroidNetworking.get(Constants.BASE_URL + "/api/fields/{category}")
                .addPathParameter("category", category)
                .setPriority(Priority.HIGH)
                .build()
                .getAsJSONObject(new JSONObjectRequestListener() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            if (fieldAdapter != null) {
                                fieldAdapter.clearData();
                                fieldAdapter.notifyDataSetChanged();
                            }
                            if (list != null)  list.clear();

                            JSONArray data = response.getJSONArray("data");
                            if(data == null) {
                                toast("Tidak ada data");
                                return;
                            }
                            System.out.println("Debug : " + data);
                                if (data.length() <= 0){
                                    tvCondition.setVisibility(View.VISIBLE);
                                    tvCondition.setText(Constants.TEXT_LOAD_NOL);
                                    ivReload.setVisibility(View.GONE);
                                    rv_Fields.setVisibility(View.GONE);
                                    mShimmerViewContainer.stopShimmer();
                                    mShimmerViewContainer.setVisibility(View.GONE);
                                }else{
                                for (int position = 0; position < data.length(); position++) {
                                    JSONObject field = data.getJSONObject(position);
                                    Field item = new Field();
                                    item.setId(field.getString("id"));
                                    item.setName(field.getString("name"));
                                    item.setAddress(field.getString("address"));
                                    item.setPrice(field.getString("price"));
                                    item.setPhoto(Constants.BASE_URL + "/storage/" + field.getString("picture"));
                                    item.setLocation(field.getString("location"));
                                    item.setOpen(field.getString("open"));
                                    item.setClose(field.getString("close"));
                                    list.add(item);
                                }
                                showRecycler();

                                mShimmerViewContainer.stopShimmer();
                                mShimmerViewContainer.setVisibility(View.GONE);
                                rv_Fields.setVisibility(View.VISIBLE);
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
                        rv_Fields.setVisibility(View.GONE);
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

    @Override
    public void onResume() {
        super.onResume();
        mShimmerViewContainer.startShimmer();
    }

    @Override
    public void onPause() {
        mShimmerViewContainer.stopShimmer();
        super.onPause();
    }
}