import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
import { getFirestore, updateDoc, doc } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyDjWfyGpv_ECHnkHABYEss7J0unCrLH0ok",
  authDomain: "kofee-manila.firebaseapp.com",
  databaseURL: "https://kofee-manila-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "kofee-manila",
  storageBucket: "kofee-manila.appspot.com",
  messagingSenderId: "296750304629",
  appId: "1:296750304629:web:39d6e2d377dfff5984d73c"
};

// Initialize Firebase

export async function updateDocument(orderid, newmessage) {
  const app = initializeApp(firebaseConfig);
  const db = getFirestore(app);

  const orderRef = doc(db, "user_updates", String(orderid));

  await updateDoc(orderRef, {
    message: newmessage
  });

  console.log(orderid + " updated" )
}