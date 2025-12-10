import Card from "react-bootstrap/Card";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockInventory = [
  { id: 1, name: "POS Terminal", sku: "POS-01", stock: 12 },
  { id: 2, name: "Barcode Scanner", sku: "SCAN-01", stock: 35 },
];

function InventoryPage() {
  return (
    <div>
      <Header title="Inventory" />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Name", accessor: "name" },
              { header: "SKU", accessor: "sku" },
              { header: "Stock", accessor: "stock" },
            ]}
            rows={mockInventory}
          />
        </Card.Body>
      </Card>
    </div>
  );
}

export default InventoryPage;

