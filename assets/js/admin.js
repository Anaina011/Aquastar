import { initializeApp } from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
import {
    getFirestore,
    collection,
    addDoc,
    getDocs,
    deleteDoc,
    doc,
    updateDoc,
} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-firestore.js";
import {
    getStorage,
    ref,
    uploadBytesResumable,
    getDownloadURL,
} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-storage.js";


// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const storage = getStorage(app);

// References
const productName = document.getElementById("product-name");
const productDescription = document.getElementById("product-description");
const productCategory = document.getElementById("product-category");
const productImage = document.getElementById("product-image");
const addProductBtn = document.getElementById("add-product-btn");
const productList = document.getElementById("product-list");

// Add Product
addProductBtn.addEventListener("click", async () => {
    const name = productName.value;
    const description = productDescription.value;
    const category = productCategory.value;
    const imageFile = productImage.files[0];

    if (!name || !description || !category || !imageFile) {
        alert("Please fill out all fields.");
        return;
    }

    try {
        // Upload Image to Firebase Storage
        const imageRef = ref(storage, `products/${imageFile.name}`);
        const uploadTask = await uploadBytesResumable(imageRef, imageFile);
        const imageURL = await getDownloadURL(uploadTask.ref);

        // Add Product to Firestore
        await addDoc(collection(db, "products"), {
            name,
            description,
            category,
            image: imageURL,
        });

        alert("Product added successfully!");
        loadProducts();
        clearForm();
    } catch (error) {
        console.error("Error adding product:", error);
        alert("Error adding product. Please try again.");
    }
});

// Load Products
async function loadProducts() {
    try {
        const querySnapshot = await getDocs(collection(db, "products"));
        productList.innerHTML = "";
        querySnapshot.forEach((doc) => {
            const product = doc.data();
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${product.name}</td>
                <td>${product.description}</td>
                <td>${product.category}</td>
                <td><img src="${product.image}" alt="${product.name}" style="width: 100px;"></td>
                <td>
                    <button onclick="deleteProduct('${doc.id}')">Delete</button>
                </td>
            `;
            productList.appendChild(row);
        });
    } catch (error) {
        console.error("Error loading products:", error);
    }
}

// Delete Product
async function deleteProduct(id) {
    try {
        await deleteDoc(doc(db, "products", id));
        alert("Product deleted successfully!");
        loadProducts();
    } catch (error) {
        console.error("Error deleting product:", error);
    }
}

// Clear Form
function clearForm() {
    productName.value = "";
    productDescription.value = "";
    productCategory.value = "";
    productImage.value = null;
}

// Initial Load
loadProducts();
