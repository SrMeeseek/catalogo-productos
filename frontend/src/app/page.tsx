import type { PaginatedProducts } from "@/types/product";
import ProductCatalog from "@/components/ProductCatalog";
import styles from "./page.module.css";

async function getProducts(): Promise<PaginatedProducts> {
  const res = await fetch("http://127.0.0.1:8000/api/products", {
    cache: "no-store",
  });
  if (!res.ok) return { data: [], current_page: 1, last_page: 1, total: 0 };
  return res.json();
}

export default async function Home() {
  const initial = await getProducts();

  return (
    <main className={styles.main}>
      <h1 className={styles.title}>Productos disponibles</h1>
      <ProductCatalog initial={initial} />
    </main>
  );
}
