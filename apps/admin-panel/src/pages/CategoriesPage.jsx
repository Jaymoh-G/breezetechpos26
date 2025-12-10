import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import DataTable from "../components/Table";
import Header from "../components/Header";

const mockCategories = [
  { id: 1, name: "Hardware", slug: "hardware" },
  { id: 2, name: "Software", slug: "software" },
];

function CategoriesPage() {
  return (
    <div>
      <Header title="Categories" actionLabel="Add Category" onAction={() => {}} />
      <Card className="shadow-sm">
        <Card.Body>
          <DataTable
            columns={[
              { header: "Name", accessor: "name" },
              { header: "Slug", accessor: "slug" },
            ]}
            rows={mockCategories}
            renderActions={() => (
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
    </div>
  );
}

export default CategoriesPage;

