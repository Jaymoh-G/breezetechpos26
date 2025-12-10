import { useState } from "react";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import DataTable from "../components/Table";
import Header from "../components/Header";
import Modal from "../components/Modal";
import TextInput from "../components/form/TextInput";
import SelectInput from "../components/form/SelectInput";
import { useFetch } from "../hooks/useFetch";

const mockProducts = [
  { id: 1, name: "POS Terminal", sku: "POS-01", price: 899, stock: 12, category: "Hardware" },
  { id: 2, name: "Barcode Scanner", sku: "SCAN-01", price: 199, stock: 35, category: "Hardware" },
];

function ProductsPage() {
  const { data = mockProducts } = useFetch("products", "/products", { enabled: false });
  const [showModal, setShowModal] = useState(false);

  return (
    <div>
      <Header title="Products" actionLabel="Add Product" onAction={() => setShowModal(true)} />
      <Row>
        <Col>
          <Card className="shadow-sm">
            <Card.Body>
              <DataTable
                columns={[
                  { header: "Name", accessor: "name" },
                  { header: "SKU", accessor: "sku" },
                  { header: "Category", accessor: "category" },
                  { header: "Price", render: (r) => `$${r.price}` },
                  { header: "Stock", accessor: "stock" },
                ]}
                rows={data}
                renderActions={(row) => (
                  <div className="d-flex gap-2">
                    <Button size="sm" variant="outline-primary">
                      Edit
                    </Button>
                    <Button size="sm" variant="outline-danger">
                      Delete
                    </Button>
                  </div>
                )}
              />
            </Card.Body>
          </Card>
        </Col>
      </Row>

      <Modal show={showModal} title="Add Product" onClose={() => setShowModal(false)}>
        <Form>
          <TextInput label="Name" name="name" placeholder="Product name" />
          <TextInput label="SKU" name="sku" placeholder="SKU" />
          <SelectInput
            label="Category"
            name="category"
            options={[
              { value: "hardware", label: "Hardware" },
              { value: "software", label: "Software" },
            ]}
          />
          <TextInput label="Price" name="price" type="number" placeholder="0.00" />
          <TextInput label="Stock" name="stock" type="number" placeholder="0" />
          <Button variant="primary" className="w-100">
            Save
          </Button>
        </Form>
      </Modal>
    </div>
  );
}

export default ProductsPage;

