import type { Product } from "@/types/product";
import styles from "./ProductCard.module.css";

export default function ProductCard({ product }: { readonly product: Product }) {
  return (
    <article className={styles.card}>
      <div className={styles.imageWrapper}>
        {product.image ? (
          <img
            src={`http://127.0.0.1:8000/storage/${product.image}`}
            alt={product.name}
            className={styles.image}
            loading="lazy"
          />
        ) : (
          <div className={styles.placeholder}>
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2ZM5 5h14v9.586l-3-3-4.293 4.293-2-2L5 18.172V5Zm0 14v-.414l4.707-4.707 2 2L16 12l3 3V19H5Z" />
            </svg>
            <span>Sin imagen</span>
          </div>
        )}
      </div>
      <div className={styles.header}>
        <h2 className={styles.name}>{product.name}</h2>
        <span className={styles.unit}>{product.unit}</span>
      </div>
      <p className={styles.brand}>{product.brand.name}</p>
      <p className={styles.observations}>{product.observations}</p>
      <div className={styles.footer}>
        <span className={styles.price}>${product.price.toLocaleString('es-CO')}</span>
      </div>
    </article>
  );
}
