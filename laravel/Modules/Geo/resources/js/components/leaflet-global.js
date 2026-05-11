import L from 'leaflet';

// Explicitly set Leaflet as global
window.L = L;

// Manual implementation of DistanceGrid if missing from plugin
console.log('--- LEAFLET GLOBAL DEBUG ---', !!L.DistanceGrid);
if (!L.DistanceGrid) {
    console.log('Defining DistanceGrid manually...');
    L.DistanceGrid = function (cellSize) {
        this._cellSize = cellSize;
        this._sqCellSize = cellSize * cellSize;
        this._grid = {};
        this._objectPoint = {};
    };

    L.DistanceGrid.prototype = {
        addObject: function (obj, point) {
            var x = this._getCoord(point.x),
                y = this._getCoord(point.y),
                grid = this._grid,
                row = grid[y] = grid[y] || {},
                cell = row[x] = row[x] || [],
                id = L.Util.stamp(obj);

            this._objectPoint[id] = point;
            cell.push(obj);
        },

        updateObject: function (obj, point) {
            this.removeObject(obj, this._objectPoint[L.Util.stamp(obj)]);
            this.addObject(obj, point);
        },

        removeObject: function (obj, point) {
            var x = this._getCoord(point.x),
                y = this._getCoord(point.y),
                grid = this._grid,
                row = grid[y] = grid[y] || {},
                cell = row[x] = row[x] || [],
                i, len;

            delete this._objectPoint[L.Util.stamp(obj)];

            for (i = 0, len = cell.length; i < len; i++) {
                if (cell[i] === obj) {
                    cell.splice(i, 1);
                    if (len === 1) {
                        delete row[x];
                    }
                    return true;
                }
            }
        },

        eachObject: function (fn, context) {
            var i, j, k, len, row, cell, grid = this._grid;
            for (i in grid) {
                row = grid[i];
                for (j in row) {
                    cell = row[j];
                    for (k = 0, len = cell.length; k < len; k++) {
                        fn.call(context, cell[k]);
                    }
                }
            }
        },

        getNearObjects: function (point) {
            var x = this._getCoord(point.x),
                y = this._getCoord(point.y),
                i, j, k, len, row, cell,
                sqDist,
                ret = [],
                grid = this._grid;

            for (i = y - 1; i <= y + 1; i++) {
                row = grid[i];
                if (row) {
                    for (j = x - 1; j <= x + 1; j++) {
                        cell = row[j];
                        if (cell) {
                            for (k = 0, len = cell.length; k < len; k++) {
                                sqDist = this._sqDist(this._objectPoint[L.Util.stamp(cell[k])], point);
                                if (sqDist <= this._sqCellSize) {
                                    ret.push(cell[k]);
                                }
                            }
                        }
                    }
                }
            }
            return ret;
        },

        _getCoord: function (x) {
            return Math.floor(x / this._cellSize);
        },

        _sqDist: function (p1, p2) {
            var dx = p1.x - p2.x,
                dy = p1.y - p2.y;
            return dx * dx + dy * dy;
        }
    };
}

export default L;
