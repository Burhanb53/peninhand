#include<iostream>
using namespace std;


int power(int n){
if(n==0) return 1;
int smaller=power(n-1);
int bigger=2*smaller;
return bigger;

}
int main(){
    int n;
    cout<<"enter va;ue of n";
    cin>>n;
   //This program will calculate the    2^n using recursion
   cout<<power(n);
    return 0;
}